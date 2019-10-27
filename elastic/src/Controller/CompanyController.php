<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use App\Entity\SuperHero;
use App\SearchRepository\SuperHeroRepository;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route("search/nativeQuery", name="superhero_search")
     */
    public function searchNativeQueryCompany( Request $request)
    {
        $start = microtime(true);
        $searchName = $request->get('name');
        $searchPrice = $request->get('price');
        $searchNumber = $request->get('number');
        $limit = $request->get('limit');
        $rep = $repository = $this->getDoctrine()->getRepository(Company::class);
        $companies = $rep->searchNativeQuery($searchName,$searchPrice,$searchNumber,$limit);
        $time = microtime(true) - $start;
        return $this->getJson($companies,$time,'nativeQuery',$limit);
    }


    /**
     * @Route("/search/elastic", name="search")
     */
    public function searchElasticCompany(RepositoryManagerInterface $manager, Request $request)
    {
        $start = microtime(true);
        $searchName = $request->get('name');
        $searchPrice = $request->get('price');
        $searchNumber = $request->get('number');
        $limit = $request->get('limit');
        $repository = $manager->getRepository(Company::class);
        $companies = $repository->search($searchName,$searchPrice,$searchNumber,$limit);
        $time = microtime(true) - $start;
        return $this->getJson($companies,$time,'elastic',$limit);
    }


    /**
     * @Route("/create_company", name="create_company")

     */
    public function create_company(Request $request)
    {
//        $query = '2';
//        $mngr = $this->get('fos_elastica.index_manager');
//
//        $search = $mngr->getIndex('mysql')->createSearch();
//        $search->addType('price');
//        $search->addType('number');
//        $resultSet = $search->search($query);
//
//        $transformer = $this->get('fos_elastica.elastica_to_model_transformer.collection.app');
//        $results = $transformer->transform($resultSet->getResults());
//        dd($results);

        for ($i = 0; $i < 100; $i++) {
            $doctrine = $this->getDoctrine()->getManager();
            for ($a = 0; $a < 1000; $a++) {
                $product = new Company();
                $product->setName(md5(rand(0, 10000)));
                $product->setNumber(rand(0, 10000));
                $product->setPrice(rand(0, 10000));
                $doctrine->persist($product);
            }
            $doctrine->flush();
        }

        return new JsonResponse([]);
    }

    private function getJson($companies,$time,$name,$limit){
        $data = [];

        foreach ($companies as $company) {
            $data[] = [
                'name' => $company->getName(),
                'price' => $company->getPrice(),
                'number' => $company->getNumber(),
            ];
        }
        return new JsonResponse(['count'=>count($data)]);

        return new JsonResponse(['time'=>$time,'name'=>$name,'limit'=>$limit]);
    }
}
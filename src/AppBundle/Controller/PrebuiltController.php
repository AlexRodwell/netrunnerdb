<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PrebuiltController extends Controller
{
    /**
     * @param string                 $prebuilt_code
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws \Doctrine\DBAL\DBALException
     */
    public function viewAction(string $prebuilt_code, EntityManagerInterface $entityManager)
    {
        $response = new Response();
        $response->setPublic();
        $response->setMaxAge($this->getParameter('short_cache'));

        $dbh = $entityManager->getConnection();

        $rows = $dbh->executeQuery(
                "SELECT
                   p.id,
                   p.date_update,
                   p.name,
                   p.date_creation,
                   c.code identity_code,
                   f.code faction_code
                 from prebuilt p
                   join card c on p.identity_id=c.id
                   join faction f on p.faction_id=f.id
                 where p.code=?
                       ",

            [$prebuilt_code]
        )->fetchAll();

        if (empty($rows)) {
            throw $this->createNotFoundException();
        }

        $prebuilt = $rows[0];
        $prebuilt_id = $prebuilt['id'];

        $cards = $dbh->executeQuery(
                "SELECT
                   c.code card_code,
                   s.quantity qty
                 from prebuiltslot s
                   join card c on s.card_id=c.id
                 where s.prebuilt_id=?
                 order by c.code asc",

            [$prebuilt_id]
        )->fetchAll();


        $prebuilt['cards'] = $cards;

        return $this->render('/Prebuilt/view.html.twig', [
                'pagetitle' => $prebuilt['name'],
                'prebuilt' => $prebuilt
        ], $response);
    }
}

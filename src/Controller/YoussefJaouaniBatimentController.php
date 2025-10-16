<?php

namespace App\Controller;

use App\Entity\Batiment;
use App\Repository\BatimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class YoussefJaouaniBatimentController extends AbstractController
{
    #[Route('/batiment', name: 'app_batiment_index')]
    public function index(): Response
    {
        return new Response("
            <h1>Gestion des bâtiments - Youssef Jaouani</h1>
            <ul>
                <li><a href='/batiment/list'>Voir la liste</a></li>
                <li><a href='/batiment/create'>Ajouter un bâtiment</a></li>
            </ul>
        ");
    }

    #[Route('/batiment/list', name: 'app_batiment_list')]
    public function list(BatimentRepository $batimentRepository): Response
    {
        $batiments = $batimentRepository->findAll();

        $html = "<h2>Liste des Bâtiments</h2><ul>";
        foreach ($batiments as $b) {
            $html .= "<li>
                        <b>{$b->getNom()}</b> | Étages: {$b->getNbetage()} | Disponible: {$b->getDisponible()} |
                        <a href='/batiment/details/{$b->getId()}'>Détails</a> |
                        <a href='/batiment/edit/{$b->getId()}'>Modifier</a> |
                        <a href='/batiment/delete/{$b->getId()}'>Supprimer</a>
                      </li>";
        }
        $html .= "</ul><br><a href='/batiment/create'>Créer un nouveau bâtiment</a>";

        return new Response($html);
    }

    #[Route('/batiment/details/{id}', name: 'app_batiment_details')]
    public function details($id, BatimentRepository $batimentRepository): Response
    {
        $b = $batimentRepository->find($id);
        if (!$b) {
            return new Response("<h3>Bâtiment non trouvé !</h3>");
        }

        $html = "
            <h2>Détails du bâtiment</h2>
            <p><b>Nom:</b> {$b->getNom()}</p>
            <p><b>Nombre d'étages:</b> {$b->getNbetage()}</p>
            <p><b>Date de construction:</b> {$b->getDateconstruction()->format('Y-m-d')}</p>
            <p><b>Disponible:</b> {$b->getDisponible()}</p>
            <a href='/batiment/list'>Retour à la liste</a>
        ";

        return new Response($html);
    }

    #[Route('/batiment/create', name: 'app_batiment_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $batiment = new Batiment();
            $batiment->setNom($request->request->get('nom'));
            $batiment->setNbetage((int)$request->request->get('nbetage'));
            $batiment->setDateconstruction(new \DateTime($request->request->get('dateconstruction')));
            $batiment->setDisponible($request->request->get('disponible'));

            $em->persist($batiment);
            $em->flush();

            return $this->redirectToRoute('app_batiment_list');
        }

        $html = "
            <h2>Créer un nouveau bâtiment</h2>
            <form method='POST'>
                <label>Nom:</label><br>
                <input type='text' name='nom' required><br><br>

                <label>Nombre d'étages:</label><br>
                <input type='number' name='nbetage' required><br><br>

                <label>Date de construction:</label><br>
                <input type='date' name='dateconstruction' required><br><br>

                <label>Disponible:</label><br>
                <input type='text' name='disponible' required><br><br>

                <button type='submit'>Enregistrer</button>
            </form>
            <br><a href='/batiment/list'>Retour à la liste</a>
        ";

        return new Response($html);
    }

    #[Route('/batiment/edit/{id}', name: 'app_batiment_edit', methods: ['GET', 'POST'])]
    public function edit($id, Request $request, BatimentRepository $repo, EntityManagerInterface $em): Response
    {
        $batiment = $repo->find($id);
        if (!$batiment) {
            return new Response("<h3>Bâtiment introuvable</h3>");
        }

        if ($request->isMethod('POST')) {
            $batiment->setNom($request->request->get('nom'));
            $batiment->setNbetage((int)$request->request->get('nbetage'));
            $batiment->setDateconstruction(new \DateTime($request->request->get('dateconstruction')));
            $batiment->setDisponible($request->request->get('disponible'));
            $em->flush();

            return $this->redirectToRoute('app_batiment_list');
        }

        $html = "
            <h2>Modifier le bâtiment</h2>
            <form method='POST'>
                <label>Nom:</label><br>
                <input type='text' name='nom' value='{$batiment->getNom()}' required><br><br>

                <label>Nombre d'étages:</label><br>
                <input type='number' name='nbetage' value='{$batiment->getNbetage()}' required><br><br>

                <label>Date de construction:</label><br>
                <input type='date' name='dateconstruction' value='{$batiment->getDateconstruction()->format('Y-m-d')}' required><br><br>

                <label>Disponible:</label><br>
                <input type='text' name='disponible' value='{$batiment->getDisponible()}' required><br><br>

                <button type='submit'>Mettre à jour</button>
            </form>
            <br><a href='/batiment/list'>Retour à la liste</a>
        ";

        return new Response($html);
    }

    #[Route('/batiment/delete/{id}', name: 'app_batiment_delete')]
    public function delete($id, BatimentRepository $repo, EntityManagerInterface $em): Response
    {
        $batiment = $repo->find($id);
        if ($batiment) {
            $em->remove($batiment);
            $em->flush();
        }

        return $this->redirectToRoute('app_batiment_list');
    }
}

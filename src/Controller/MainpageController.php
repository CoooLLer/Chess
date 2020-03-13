<?php

namespace App\Controller;

use App\Model\ChessGame;
use App\Validator\FenString;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainpageController extends AbstractController
{
    /**
     * @Route("/", name="mainpage")
     */
    public function index(Request $request, ChessGame $chess)
    {
        $form = $this
            ->createFormBuilder(null, ['method' => 'GET'])
            ->add('fen', TextType::class, [
                'label' => 'FEN formatted string',
                'required' => false,
                'constraints' => [
                    new FenString()
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $chess->load($form->getData()['fen']);
        }

        return $this->render('mainpage/index.html.twig', [
            'form' => $form->createView(),
            'board' => $chess->boardArray(),
            'moves' => $chess->moves(),
            'whoseMove' => $chess->turnFull()
        ]);
    }
}

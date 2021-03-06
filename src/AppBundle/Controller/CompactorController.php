<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\ComparisonCompactor\Compactor;
use AppBundle\Form\CompactorType;

class CompactorController extends Controller
{
    /**
     * @Route("/compactor", name="compactor")
     */
    public function compactorAction(Request $request)
    {
        $form = $this->createForm(CompactorType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compactorData = $form->getData();
            $contextLength = $compactorData->getCotext();
            $expected = $compactorData->getExpected();
            $actual = $compactorData->getActual();

            $cc = new Compactor($contextLength, $expected, $actual);
            $result = $cc->compact();

            return $this->render('compactor/results.html.twig', [
                'contextLength' => $contextLength,
                'expected' => $expected,
                'actual' => $actual,
                'result' => $result,
            ]);
        }

        return $this->render('compactor/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}


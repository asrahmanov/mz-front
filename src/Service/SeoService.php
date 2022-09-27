<?php

namespace App\Service;

use App\Repository\SeoRuleRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SeoService
{
    private ?Request $request;
    private SeoRuleRepository $seoRuleRepository;
    public function __construct(RequestStack $requestStack, SeoRuleRepository $seoRuleRepository)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->seoRuleRepository = $seoRuleRepository;
    }

    public function getTitle(): ?string {
        $rule = $this->seoRuleRepository->findOneBy([
            'path'=>$this->request->getPathInfo()
        ]);
        return $rule?->getTitle();
    }

    public function getDescription(): ?string {
        $rule = $this->seoRuleRepository->findOneBy([
            'path'=>$this->request->getPathInfo()
        ]);
        return $rule?->getDescription();
    }

    public function getH1(): ?string {
        $rule = $this->seoRuleRepository->findOneBy([
            'path'=>$this->request->getPathInfo()
        ]);
        return $rule?->getH1();
    }

    public function getRobots(): ?string {
        $rule = $this->seoRuleRepository->findOneBy([
            'path'=>$this->request->getPathInfo()
        ]);
        return $rule?->getRobots();
    }

    public function getCanonical(): ?string {
        $rule = $this->seoRuleRepository->findOneBy([
            'path'=>$this->request->getPathInfo()
        ]);
        return $rule?->getCanonical();
    }
}
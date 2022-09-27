<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleTag;
use App\Entity\DoctorScheduleDate;
use App\Repository\ArticleRepository;
use App\Repository\ArticleTagRepository;
use App\Repository\DoctorRepository;
use App\Repository\DoctorScheduleDateRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles/{tagSlug?}", name="articles")
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(
        ArticleRepository $articleRepository,
        ArticleTagRepository $tagRepository,
        DoctorRepository $doctorRepository,
        Request $request,
        $tagSlug = null,
    ): Response
    {
        $page = $request->get('page', 1);

        $filter = [];
        $filter['tag_slug'] = $tagSlug;
        $filter['doctor'] = $request->get('doctor');
        $filter['name'] = $request->get('name');
        $filter['order'] = $request->get('order');

        $articles = $articleRepository->search($filter, $page);
        $authors = $doctorRepository->getArticleAuthors();

        $tags = $tagRepository->search();
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'tags' => $tags,
            'authors' => $authors,
            'currentTagSlug' => $tagSlug,
        ]);
    }

    /**
     * @Route("/article/{slug}", name="article.show")
     * @param Article $article
     */
    public function show(
        Article $article,
        ArticleRepository $articleRepository,
        Request $request
    )
    {
        $articlesViewed = $request->getSession()->get('articlesViewed', []);
        if (! in_array($article->getId(), $articlesViewed)) {
            $article->setViewsNum($article->getViewsNum() + 1);
            $this->getDoctrine()->getManager()->flush();
            $articlesViewed[] = $article->getId();
            $request->getSession()->set('articlesViewed', $articlesViewed);
        }

        $popularArticles = $articleRepository->getPopular([$article->getId()]);
        $totalArticlesCount = $articleRepository->count([]);

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'popularArticles' => $popularArticles,
            'totalArticlesCount' => $totalArticlesCount,
        ]);
    }

    /**
     * @Route("/article/{id}/vote/{value}", requirements={"value":"[1-5]"})
     * @param Article $article
     * @param $value
     */
    public function vote(Article $article, $value, Request $request)
    {
        $articlesVoted = $request->getSession()->get('articlesVoted', []);

        if (! in_array($article->getId(), $articlesVoted)) {
            $score = $article->getRating() * $article->getVotesCount() + $value;
            $article->setVotesCount($article->getVotesCount() + 1);
            $article->setRating($score / $article->getVotesCount());
            $this->getDoctrine()->getManager()->flush();

            $articlesVoted[] = $article->getId();
            $request->getSession()->set('articlesVoted', $articlesVoted);
        }

        return new JsonResponse([
            'result' => 'success',
            'voteCount' => $article->getVotesCount(),
            'rating' => $article->getRating()
        ]);
    }
}

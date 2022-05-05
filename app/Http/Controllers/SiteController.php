<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class SiteController extends ParentController
{
    const EMPTY_IMAGE = 'upload/no-image.png';

    /**
     * Показывает все статьи
     *
     * GET /
     *
     * @return View
     */
    public function index()
    {
        $articles = $this->allArticles();

        // $categories = Category::select(['id', 'title'])
        //     ->orderBy('title')
        //     ->where('published', true)
        //     ->get();
        // dd($categories);

        return view('blog.index')->with([
            // 'articles' => $articles->paginate(self::PAGINATE),
            'articles' => $articles->paginate(self::PAGINATE),
            'categories' => $this->showCategories(),
            // 'popular' => $this->popularArticles($articles),
            // 'recent' => $this->recentArticles($articles),
            // 'tags' => $this->showTags(),
            // 'empty' => self::EMPTY_IMAGE,
        ]);
    }

    /**
     * Показывает одну статью
     *
     * GET /article.{id}
     *
     * @param $articleId
     *
     * @return $this
     */
    public function show($articleId)
    {
        /**
         * @var Article $article
         */
        $article = Article::findOrFail($articleId);
        $article->viewed += 1;
        $article->save();

        $articles = $this->allArticles();

        return view('article')->with([
            'article' => $article,
            'popular' => $this->popularArticles($articles),
            'recent' => $this->recentArticles($articles),
            // 'categories' => $this->showCategories(),
            'categories' => 'asasas',
            'tags' => $this->showTags(),
            // 'image' => $this->getFiles($articleId),
            'comments' => $this->getComments($articleId),
            'empty' => self::EMPTY_IMAGE,
        ]);
    }

    /**
     * Показывает статьи по категории
     *
     * @param $categoryId
     *
     * @return $this
     */
    public function showByCategory($categoryId)
    {
        $category = (new Category())->find($categoryId)->first(['title']);

        $articles = $this->allArticles(null, $categoryId);

        return view('index')->with([
            'articles' => $articles->paginate(self::PAGINATE),
            'category' => $category,
            'popular' => $this->popularArticles($articles),
            'recent' => $this->recentArticles($articles),
            'categories' => $this->showCategories(),
            'tags' => $this->showTags(),
            'empty' => self::EMPTY_IMAGE,
        ]);
    }

    /**
     * Показывает статьи по тегу
     *
     * @param $tagId
     *
     * @return $this
     */
    public function showByTag($tagId)
    {
        $tag = Tag::find($tagId);

        $articles = $this->allArticles($tagId);

        return view('index')->with([
            'articles' => $articles->paginate(self::PAGINATE),
            'tag' => $tag,
            'popular' => $this->popularArticles($articles),
            'recent' => $this->recentArticles($articles),
            'categories' => $this->showCategories(),
            'tags' => $this->showTags(),
            'empty' => self::EMPTY_IMAGE,
        ]);
    }
}

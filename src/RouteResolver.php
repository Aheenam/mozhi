<?php

namespace Aheenam\Mozhi;

use Aheenam\Mozhi\Documents\MarkdownDocument;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class RouteResolver
{
    /**
     * @var Filesystem
     */
    private $contentStorage;

    public function __construct(Filesystem $contentStorage)
    {
        $this->contentStorage = $contentStorage;
    }

    public function getPageByRoute(string $route): ?MarkdownDocument
    {
        $filePath = $this->getFilePath($route);

        try {
            $content = $this->contentStorage->get($filePath);
        } catch (FileNotFoundException $e) {
            return null;
        }

        return new MarkdownDocument($content);
    }

    private function getFilePath(string $route): string
    {
        if ($route === '/') {
            return 'contents/index.md';
        }
        $fileName = collect(explode('/', $route))->pop().'.md';

        return 'contents/'.$route.'/'.$fileName;
    }
}

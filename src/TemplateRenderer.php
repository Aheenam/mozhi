<?php
namespace Aheenam\Mozhi;


use Aheenam\Mozhi\Models\Page;

class TemplateRenderer
{
    /**
     * the page that the TemplateRenderer should render
     *
     * @var Page
     */
    protected $page;

    /**
     * The name of the template file that should
     * be used for the page
     *
     * @var string
     */
    protected $template;

    /**
     * TemplateRenderer constructor.
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * returns a rendered string
     *
     * @param array $data
     * @return string
     */
    public function render($data = [])
    {
        $currentTheme = self::getCurrentTheme();
        $template = $this->getTemplate();

        return view("theme::$currentTheme.$template", collect([
            'meta' => $this->page->meta(),
            'content' => $this->page->getParsedContent()
        ])->concat(collect($data)))->render();
    }

    /**
     * @return array|\Illuminate\Config\Repository|mixed|null|string
     */
    public function getTemplate()
    {
        if ( $this->template === null ) $this->template = $this->resolveTemplate();

        return $this->template;
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function getCurrentTheme()
    {
        return config('mozhi.theme');
    }

    /**
     * returns the template of the page
     * defaults to default_template of config if none set
     *
     * @return array|\Illuminate\Config\Repository|mixed|null
     */
    protected function resolveTemplate()
    {
        if ($this->page->meta('template') === null) return config('mozhi.default_template');
        return $this->page->meta('template');
    }

}
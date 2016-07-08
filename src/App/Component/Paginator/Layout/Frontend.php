<?php
namespace App\Component\Paginator\Layout;

use Phalcon\Di;
use Phalcon\Paginator\Pager;
use Phalcon\Paginator\Pager\Layout;

class Frontend extends Layout
{

    /**
     * Маска для параметра page в URL
     *
     * @var string
     */
    protected $urlPageMask = 'page={%page_number}';

    /**
     * URL для генерации ссылок пагинатора
     *
     * @var string
     */
    protected $baseUrl;

    protected $limit = 6;

    /**
     * {@inheritdoc}
     *
     * @param \Phalcon\Paginator\Pager       $pager
     * @param \Phalcon\Paginator\Pager\Range $range
     * @param string                         $baseUrl
     */
    public function __construct(Pager $pager, Pager\Range $range, $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $urlMask       = $this->getUrlWithPageMask($baseUrl);

        parent::__construct($pager, $range, $urlMask);
    }

    /**
     * {@inheritdoc}
     *
     * @param  array $options
     *
     * @return string
     */
    public function getRendered(array $options = [])
    {
        $params = [
            'nextPage'    => false,
            'prevPage'    => false,
            'currentPage' => $this->pager->getCurrentPage(),
            'pageCount'   => $this->pager->getLastPage(),
            'baseUrl'     => $this->baseUrl,
        ];

        if ($this->pager->getPreviousPage() != $this->pager->getCurrentPage()) {
            $options['page_number'] = $this->pager->getPreviousPage();
            $params['prevPage']     = $this->parseUrl($options);
        }

        if ($this->pager->getNextPage() != $this->pager->getCurrentPage()) {
            $options['page_number'] = $this->pager->getNextPage();
            $params['nextPage']     = $this->parseUrl($options);
        }

        $params['pageRange']    = $this->range->getRange();
        $params['pageRangeUrl'] = array_map(function ($value) {
            return $this->parseUrl(['page_number' => $value]);
        }, $params['pageRange']);

        $result = Di::getDefault()->getTemplate()->render('component/paginator/frontend.volt', $params);

        return $result;
    }

    /**
     * Возвращает URL для пагинации с параметром page
     *
     * @param  string $url
     *
     * @return string
     */
    protected function getUrlWithPageMask($url)
    {
        if (strpos($url, '?') !== false) {
            return $url . '&' . $this->urlPageMask;
        } else {
            return $url . '?' . $this->urlPageMask;
        }
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return parent::__toString();
        } catch (\Exception $exception) {
            return '';
        }
    }
}

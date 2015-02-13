<?php
/**
 * Created by PhpStorm.
 * User: vir-mir
 * Date: 13.02.15
 * Time: 17:22
 */

namespace VMController;


class Controller {

	/**
	 * массив параметров прищедших из Route
	 *
	 * @var array
	 */
	private $params;

	/**
	 * @var array
	 */
	private $get;

	/**
	 * @var array
	 */
	private $post;

	/**
	 * @var array
	 */
	private $cookie;

    /**
     * Заголовки по умолчанию
     * @var array
     */
    protected $headers = [
        'Cache-Control: no-cache, must-revalidate',
        'Pragma: no-cache',
    ];

    /**
     * @var int
     *  - статус ответа от сервера
     */
    private $statusHTTP = 200;

    /**
     * Формат вывода данных на экран
     *
     * @var string
     */
    private $outputDataFormat = 'html';


	public function __construct(array $params)
	{
		$this->params = $params;
		$this->get = $_GET;
		$this->post = $_POST;
		$this->cookie = $_COOKIE;
        $this
            ->setDefaultHeaders()
            ->setStatusHTTP($this->statusHTTP)
            ->setDataFormat($this->outputDataFormat);
	}

    /**
     * Установка формата ответа
     *
     * @param string $dataFormat
     * @return Controller
     */
    public function setDataFormat($dataFormat)
    {
        switch($dataFormat)
        {
            case 'png':
                $dataFormat = 'image/png';
                break;
            case 'gif':
                $dataFormat = 'image/gif';
                break;
            case 'jpg':
            case 'jpeg':
                $dataFormat = 'image/jpeg';
                break;
            case 'pdf':
                $dataFormat = 'application/pdf';
                break;
            case 'json':
                $dataFormat = 'application/json';
                break;
            case 'text':
                $dataFormat = 'text/plain';
                break;
            case 'xml':
                $dataFormat = 'text/xml';
                break;
            case 'html':
            default:
                $dataFormat = 'text/html';
                break;
        }
        return $this->setHeader("Content-Type: {$dataFormat}; charset=utf-8");
    }

    /**
     * Установка заголовков по умолчанию
     *
     * @return $this
     */
    protected function setDefaultHeaders()
    {
        foreach ($this->headers as $header)
        {
            $this->setHeader($header);
        }
        return $this;
    }

    /**
     * @param $url
     */
    public function redirect($url)
    {
        header("Location: {$url}", true, 301);
        exit;
    }

    /**
     * Получение кода статуса ответа
     *
     * @return int
     */
    public function getStatusHTTP()
    {
        return $this->statusHTTP;
    }

    /**
     * Установка статуса ответа от сервера
     *
     * @param int $status
     * @return $this
     */
    public function setStatusHTTP($status)
    {
        $this->statusHTTP = $status;
        http_response_code($this->statusHTTP);
        return $this;
    }

    /**
     * Установка Http заголовков
     *
     * @param $header
     * @return $this
     */
    public function setHeader($header)
    {
        header($header);
        return $this;
    }

	/**
	 * Отправляет пользователю cookie
	 *
	 * @param $name
	 * @param string $value
	 * @param bool $persistent
	 * @param string $path
	 * @param string $domain
	 * @param int $expire
	 */
	public function setCookie($name, $value = '', $persistent = true, $path = '/', $domain = '', $expire = 0)
	{
		if ($expire == 0)
		{
			if ($persistent)
			{
				$expire = time() + 31536000;
			}
			else
			{
				$expire = 0;
			}
		}

		@setcookie($name, $value, $expire, $path, $domain);
		$_COOKIE[$name] = $value;
	}

	/**
	 * Удаляет cookie пользователя
	 *
	 * @param $name
	 * @param string $domain
	 * @param string $path
	 */
	public function removeCookie($name, $domain = '', $path = '/')
	{
		@setcookie($name, '', -100000, $path, $domain);
		if (array_key_exists($name, $_COOKIE))
		{
			unset($_COOKIE[$name]);
		}
	}

	/**
	 * Получение параметров из $_GET
	 *
	 * @param $key
	 * @param null $default
	 *
	 * @return null
	 */
	public function getCollectionGet($key, $default = null)
	{
		return array_key_exists($key, $this->get) ? $this->get[$key] : $default;
	}

	/**
	 * Получение параметров из $_POST
	 *
	 * @param $key
	 * @param null $default
	 *
	 * @return null
	 */
	public function getCollectionPost($key, $default = null)
	{
		return array_key_exists($key, $this->post) ? $this->post[$key] : $default;
	}

	/**
	 * Получение параметров из $_COOKIE
	 *
	 * @param $key
	 * @param null $default
	 *
	 * @return null
	 */
	public function getCollectionCookie($key, $default = null)
	{
		return array_key_exists($key, $this->cookie) ? $this->cookie[$key] : $default;
	}

	/**
	 * Получение параметров из Route
	 *
	 * @param $key
	 * @param null $default
	 *
	 * @return null
	 */
	public function getCollectionRoute($key, $default = null)
	{
		return array_key_exists($key, $this->params) ? $this->params[$key] : $default;
	}


} 
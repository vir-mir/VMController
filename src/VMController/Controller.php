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


	public function __construct(array $params)
	{
		$this->params = $params;
		$this->get = $_GET;
		$this->post = $_POST;
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
<?php


if (! function_exists('buildApiResponse')) {
    function buildApiResponse($data, $status_code = '200') {

        return [
            'status' => 'ok',
            'code' => $status_code,
            'data' => (object) $data
        ];
    }
}

if (!function_exists('varView')) {

    /**
     * Metodo para Declarar Variables globales para JS
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @return array
     */
    function varView($view = null, $data = array(), $mergeData = array())
    {
        $varView = array(
            'baseUrl' => Config::get('app.url'),
            'urlMiddleware' => Config::get('app.middlewareUrl'),
        );

        $router = Route::getCurrentRoute()->getActionName();
        $module = substr($router, strripos($router, 'Controllers\\') + 12, (strrpos($router, '\\') - (strripos($router, 'Controllers\\') + 12)));
        $controller = substr($router, strripos($router, '\\') + 1, (strpos($router, 'Controller@')) - (strripos($router, '\\') + 1));
        $action = substr($router, strpos($router, '@') + 1);

        $varView['module'] = ((!empty($module)) ? $module : '');
        $varView['controller'] = ((!empty($controller)) ? $controller : '');
        $varView['action'] = ((!empty($action)) ? $action : '');

        return $varView;
    }

}

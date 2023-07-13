<?php

/**
 * 路由处理类
 *
 * @author winter
 */
class MyRoute {
    
    public static function getRouterName($route_action) {
        $router = Route::getRoutes()->getByAction($route_action);
        return $router ? $router->getName() : '';
    }

}

<?php

trait ParamTrait {

    /**
     * Transform array from [{"code":"X","value":"Y"},...] to ["X" => "Y",...]
     *
     * @param array $params Params array
     * @return array
     */
    public function mapParams(array $params): array {
        $paramsMap = [];
        foreach ($params as $param) {
            if (isset($param['code']) && isset($param['value'])) {
                $paramsMap[$param['code']] = $param['value'];
            }
        }
        return $paramsMap;
    }

}
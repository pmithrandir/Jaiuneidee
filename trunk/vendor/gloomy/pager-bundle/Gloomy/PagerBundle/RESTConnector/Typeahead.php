<?php

namespace Gloomy\PagerBundle\RESTConnector;

class Typeahead extends RESTBase
{
    public function __construct($request, $pager, array $config = array())
    {
        $defaultConfig  = array(
                'return' => null,
//                 'property' => 'id',
                'searchFields' => null
        );

        parent::__construct($request, $pager, array_merge($defaultConfig, $config));
    }

    public function handle()
    {
        // items per page
        $perPage = 20;

        /**
         * Pager Configuration
         */
        $fields = $this->_pager->getFields();
        $fieldsIndex = array_keys($fields);

        // Filter
        $search = $this->_request->get('query', false);
        $searchFields = $this->_config['searchFields'];
        if ($search !== false) {
            $f = array();
            $v = array();
            $o = array();
            foreach ($fieldsIndex as $key) {
                if (!is_array($searchFields) || in_array($key, $searchFields)) {
                    $f[] = $key;
                    $v[] = $search;
                    $o[] = "contains";
                }
            }
            $this->_pager->getWrapper()->setFilters($f, $v, $o, array(array(array('o' => 'or'))));
        }

        /**
         * Formatting datas
         */
        $items = $this->_pager->getItems();
        $infos = $this->_pager->getPages();

        $datas = array();
        foreach ($items as $obj) {
            $item = array();

            if ($this->_config['return']) {
                foreach ($this->_config['return'] as $key) {

                    if (isset($this->_config['mapping'][$key])) {
                        $testFields = $this->_config['mapping'][$key];
                    }
                    else {
                        $testFields = $key;
                    }

                    if (!is_array($testFields)) {
                        $testFields = array($testFields);
                    }
                    foreach ($testFields as $name) {
                        if (isset($fields[$name])) {
                            $item[$key] = $fields[$name]->readData($obj);
                            break;
                        }
                    }
                }
            }
            else {
                foreach ($fields as $field) {
                    $item[$field->getProperty()] = $field->readData($obj);
                }
            }

            $datas[] = $item;
        }

//         $datas = array();
//         $property = $this->_config['property'];
//         foreach ($items as $obj) {
//             $datas[] = $fields[$property]->readData($obj);
//         }

        return $this->jsonResponse($datas);
    }
}

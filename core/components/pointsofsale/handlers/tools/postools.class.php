<?php

class posTools
{
    public $config = [];
    /** @var modX $modx */
    protected $modx;
    /** @var pointsOfSale $pos */
    protected $pos;

    /**
     * @param pointsOfSale $pos
     * @param array        $config
     */
    function __construct(pointsOfSale &$pos, $config = [])
    {
        $this->pos = &$pos;
        $this->modx = &$this->pos->modx;
        $this->config = $config;
    }

    /**
     * @param modProcessor $processor
     * @param array        $data
     * @param string       $default_lexicon
     *
     * @return bool
     */
    public function checkProcessorRequired(modProcessor &$processor, array $data, $default_lexicon = '')
    {
        $has_error = false;
        if (is_array($data) && !empty($data)) {
            foreach ($data as $v) {
                $array = explode(':', $v);
                $key = $array[0];
                if (count($array) > 1) {
                    $lexicon = $array[1];
                } else {
                    $lexicon = $default_lexicon;
                }

                if (!$processor->getProperty($key)) {
                    $has_error = true;
                    $processor->addFieldError($key, $this->modx->lexicon($lexicon));
                }
            }
        }

        return !$has_error;
    }

    /**
     * @param string       $class_key
     * @param int          $id
     * @param modProcessor $processor
     * @param array        $data
     * @param string       $default_lexicon
     * @param array        $condition_add
     *
     * @return bool
     */
    public function checkProcessorUnique(
        $class_key = '',
        $id = 0,
        modProcessor &$processor,
        array $data,
        $default_lexicon = '',
        array $condition_add = array()
    ) {
        $has_error = false;
        if (is_array($data) && !empty($data)) {
            $classKey = empty($class_key) ? $processor->classKey : $class_key;
            $id = (empty($id) && $id !== false) ? (int)$processor->getProperty('id') : $id;

            foreach ($data as $v) {
                $array = explode(':', $v);
                $key = $array[0];
                if (count($array) > 1) {
                    $lexicon = $array[1];
                } else {
                    $lexicon = $default_lexicon;
                }

                $condition = array(
                    $key => $processor->getProperty($key),
                );
                if (!empty($condition_add)) {
                    $condition = array_merge($condition, $condition_add);
                }
                if (!empty($id)) {
                    $condition['id:!='] = $id;
                }

                if ($this->modx->getCount($classKey, $condition)) {
                    $has_error = true;
                    $processor->addFieldError($key, $this->modx->lexicon($lexicon));
                }
            }
        }

        return !$has_error;
    }

    /**
     * Shorthand for original modX::invokeEvent() method with some useful additions.
     *
     * @param       $eventName
     * @param array $params
     * @param       $glue
     *
     * @return array
     */
    public function invokeEvent($eventName, array $params = array(), $glue = '<br/>')
    {
        if (isset($this->modx->event->returnedValues)) {
            $this->modx->event->returnedValues = null;
        }
        $response = $this->modx->invokeEvent($eventName, $params);
        if (is_array($response) && count($response) > 1) {
            foreach ($response as $k => $v) {
                if (empty($v)) {
                    unset($response[$k]);
                }
            }
        }
        $message = is_array($response) ? implode($glue, $response) : trim((string)$response);
        if (isset($this->modx->event->returnedValues) && is_array($this->modx->event->returnedValues)) {
            $params = array_merge($params, $this->modx->event->returnedValues);
        }

        return array(
            'success' => empty($message),
            'message' => $message,
            'data' => $params,
        );
    }

    /**
     * @param string $action
     * @param array  $data
     *
     * @return modProcessorResponse
     */
    public function runProcessor($action = '', $data = array())
    {
        $this->modx->error->reset();
        $processorsPath = !empty($this->pos->config['processorsPath']) ? $this->pos->config['processorsPath'] : MODX_CORE_PATH;

        /* @var modProcessorResponse $response */
        $response = $this->modx->runProcessor($action, $data, array('processors_path' => $processorsPath));

        return $this->pos->config['prepareResponse'] ? $this->prepareResponse($response) : $response;
    }

    /**
     * This method returns prepared response
     *
     * @param mixed $response
     *
     * @return array|string $response
     */
    public function prepareResponse($response)
    {
        if ($response instanceof modProcessorResponse) {
            $output = $response->getResponse();
        } else {
            $message = $response;
            if (empty($message)) {
                $message = $this->modx->lexicon('err_unknown');
            }
            $output = $this->failure($message);
        }
        if ($this->pos->config['jsonResponse'] AND is_array($output)) {
            $output = $this->modx->toJSON($output);
        } elseif (!$this->pos->config['jsonResponse'] AND !is_array($output)) {
            $output = $this->modx->fromJSON($output);
        }

        return $output;
    }

    /**
     * More convenient error messages.
     *
     * @param modProcessorResponse $response
     * @param string               $glue
     *
     * @return string
     */
    public function formatProcessorErrors(modProcessorResponse $response, $glue = '<br>')
    {
        $errormsgs = array();

        if ($response->hasMessage()) {
            $errormsgs[] = $response->getMessage();
        }
        if ($response->hasFieldErrors()) {
            if ($errors = $response->getFieldErrors()) {
                foreach ($errors as $error) {
                    $errormsgs[] = $error->message;
                }
            }
        }

        return implode($glue, $errormsgs);
    }

    /**
     * Process and return the output from a Chunk by name.
     *
     * @param string $chunk
     * @param array  $params
     *
     * @return string
     */
    public function getChunk($chunk, array $params = array())
    {
        if ($pdoTools = $this->pos->getPdoTools()) {
            return $pdoTools->getChunk($chunk, $params);
        }

        return $this->modx->getChunk($chunk, $params);
    }

    /**
     * Method for transform array to placeholders
     * @var array  $array With keys and values
     * @var string $prefix
     * @return array $array Two nested arrays With placeholders and values
     */
    public function makePlaceholders(array $array = array(), $prefix = '')
    {
        $result = array(
            'pl' => array(),
            'vl' => array(),
        );
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $result = array_merge_recursive($result, $this->makePlaceholders($v, $prefix . $k . '.'));
            } else {
                $result['pl'][$prefix . $k] = '[[+' . $prefix . $k . ']]';
                $result['vl'][$prefix . $k] = $v;
            }
        }

        return $result;
    }

    /**
     * @param string $message
     * @param array  $data
     * @param array  $placeholders
     *
     * @return array|string
     */
    public function success($message = '', $data = array(), $placeholders = array())
    {
        $response = array(
            'success' => true,
            'message' => $this->modx->lexicon($message, $placeholders),
            'data' => $data,
        );

        return $this->pos->config['jsonResponse'] ? $this->modx->toJSON($response) : $response;
    }

    /**
     * @param string $message
     * @param array  $data
     * @param array  $placeholders
     *
     * @return array|string
     */
    public function failure($message = '', $data = array(), $placeholders = array())
    {
        $response = array(
            'success' => false,
            'message' => $this->modx->lexicon($message, $placeholders),
            'data' => $data,
        );

        return $this->pos->config['jsonResponse'] ? $this->modx->toJSON($response) : $response;
    }

    /**
     * @param $json
     *
     * @return int|bool
     */
    public function isJSON($json)
    {
        $valid = false;
        if (is_string($json)) {
            @json_decode($json);
            $valid = (json_last_error() === JSON_ERROR_NONE);
        }

        return $valid;
    }

    /**
     * Чистит папку в файловой системе
     *
     * @param string $path
     * @param bool   $remove_self
     */
    public function cleanDir($path, $remove_self = false)
    {
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $v) {
                if ($v != '.' && $v != '..') {
                    if (filetype($path . '/' . $v) == 'dir') {
                        $this->cleanDir($path . '/' . $v, true);
                    } else {
                        unlink($path . '/' . $v);
                    }
                }
            }
            reset($files);
            if ($remove_self) {
                rmdir($path);
            }
        } elseif (!$remove_self) {
            mkdir($path, 0755, true);
        }
    }

    /**
     * @param string $path
     * @param bool $is_url
     *
     * @return string
     */
    public function sanitizePath($path, $is_url = true)
    {
        $regexp = ['/\.*[\/|\\\]/i'];
        if ($is_url) {
            $regexp[] = '/(?<=[^:])[\/|\\\]+/i';
        } else {
            $regexp[] = '/[\/|\\\]+/i';
        }

        return preg_replace($regexp, '/', $path);
    }
}
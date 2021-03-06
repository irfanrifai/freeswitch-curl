<?php
/**
 * @package    FS_CURL
 * @subpackage FS_CURL_Configuration
 * limit.conf.php
 */

/**
 * @package    FS_CURL
 * @subpackage FS_CURL_Configuration
 * @license
 * @author     Raymond Chandler (intralanman) <intralanman@gmail.com>
 * @version    0.1
 * Write XML for limit.conf
 */
class limit_conf extends fs_configuration
{
    public function main()
    {
        $params = $this->get_params_array();
        $this->write_params_array($params);
        $this->output_xml();
    }

    /**
     * Pull limit params from the db
     * @return array
     */
    private function get_params_array()
    {
        $query = sprintf('SELECT * FROM limit_conf;');
        $res = $this->db->query($query);
        $res = $res->fetchAll();

        return $res;
    }

    /**
     * Write out the XML of params retreived from get_params_array
     * @see get_params_array
     *
     * @param array $params
     */
    private function write_params_array($params)
    {
        $this->xmlw->startElement('configuration');
        $this->xmlw->writeAttribute('name', basename(__FILE__, '.php'));
        $this->xmlw->writeAttribute('description', 'Call Limiter');
        $this->xmlw->startElement('settings');

        $param_count = count($params);
        for ($i = 0; $i < $param_count; $i++) {
            $this->comment("$param_count/$i");
            $this->xmlw->startElement('param');
            $this->xmlw->writeAttribute('name', $params[$i]['name']);
            $this->xmlw->writeAttribute('value', $params[$i]['value']);
            $this->xmlw->endElement();
        }
        $this->xmlw->endElement();
        $this->xmlw->endElement();
    }
}

<?php

/**
 * The YconfsApp class is a gate to Yii application.
 *
 */
class YconfsApp {

    protected $config = array();

    function __construct() {
        $yii = dirname(__FILE__) . '/../../framework/yiilite.php';
        require_once($yii);
        $config = include dirname(__FILE__) . '/../../protected/config/main.php';
        $this->config['params']['maxFileSize'] = $config['params']['userFileSize']; //500 * 1024;
        $this->config['params']['mainLanguage'] = $config['params']['mainLanguage'];
        $this->config['params']['fileExts'] = CMap::mergeArray($config['params']['logoExts'], $config['params']['fileExts']);
        $this->config['db'] = $config['components']['db'];
        $this->config['language'] = $config['language'];
        $RFilemanagerConsts = dirname(__FILE__) . '/../../protected/models/utils/RFilemanagerConsts.php';
        require_once($RFilemanagerConsts);
        $RFilemanagerUtils = dirname(__FILE__) . '/../../protected/models/utils/RFilemanagerUtils.php';
        require_once($RFilemanagerUtils);
    }

    public function getMaxSizeUpload() {
        return $this->config['params']['maxFileSize'];
    }

    public function language() {
        return isset($_SESSION['language']) ? $_SESSION['language'] : $this->config['language'];
    }

    public function subfolder() {
        list($access, $conf_id, $participant_id, $secret) = RFilemanagerUtils::parseAccessKey(isset($_GET['akey']) ? $_GET['akey'] : '');
        if ($participant_id !== '0') {
            return 'part_' . $participant_id;
        };
        return 'conf_' . $conf_id;
    }

    public function defaultLanguage() {
        return $this->config['params']['mainLanguage'];
    }

    /**
     *  Возвращает массив расширений файлов, которые может загружать пользователь.
     * 
     *  Returns array of file extensions that can be uploaded by users. 
     */
    public function fileExts() {
        list($access, $conf_id, $participant_id, $secret) = RFilemanagerUtils::parseAccessKey(isset($_GET['akey']) ? $_GET['akey'] : '');
        $fileExts = '';
        if ($access == 'U') {
            $connectionString = $this->config['db']['connectionString'];
            $username = $this->config['db']['username'];
            $password = $this->config['db']['password'];
            try {
                $conn = new PDO($connectionString, $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = $conn->prepare("SELECT file_exts FROM `tbl_conf` WHERE id = :conf_id");
                $query->bindParam(":conf_id", $conf_id);
                if ($query->execute()) {
                    $fileExts = $query->fetchColumn();
                };
                $conn = null;
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            if (!is_array($fileExts)) {
                $fileExts = explode(',', $fileExts);
                foreach ($fileExts as $num => &$ext) {
                    $ext = trim($ext);
                    if (empty($ext)) {
                        unset($fileExts[$num]);
                    }
                }
            }
        }
        if (empty($fileExts)) {
            $fileExts = $this->config['params']['fileExts'];
        }
        return $fileExts;
    }

    public function uploadDir() {
        return RFilemanagerConsts::$RFFolder;
    }

    public function thumbsBasePath() {
        return RFilemanagerConsts::$RFThumbsFolder;
    }

    public function accessKeys() {
        return $_SESSION[RFilemanagerConsts::$ACCESS_KEYS];
    }

}

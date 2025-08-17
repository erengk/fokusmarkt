<?php
class Language {
    private static $instance = null;
    private $translations = [];
    private $currentLang = 'tr';
    private $supportedLanguages = ['tr', 'en', 'de'];
    
    private function __construct() {
        $this->loadLanguage();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function loadLanguage() {
        // Session'dan dil tercihini al
        if (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $this->supportedLanguages)) {
            $this->currentLang = $_SESSION['lang'];
        } elseif (isset($_GET['lang']) && in_array($_GET['lang'], $this->supportedLanguages)) {
            $this->currentLang = $_GET['lang'];
            $_SESSION['lang'] = $this->currentLang;
        } else {
            // Browser dilini kontrol et
            $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'tr', 0, 2);
            if (in_array($browserLang, $this->supportedLanguages)) {
                $this->currentLang = $browserLang;
            } else {
                $this->currentLang = DEFAULT_LANG;
            }
            $_SESSION['lang'] = $this->currentLang;
        }
        
        // Dil dosyasını yükle
        $langFile = __DIR__ . '/../config/languages.json';
        if (file_exists($langFile)) {
            $this->translations = json_decode(file_get_contents($langFile), true);
        }
    }
    
    public function get($key, $params = []) {
        $keys = explode('.', $key);
        $value = $this->translations[$this->currentLang] ?? [];
        
        foreach ($keys as $k) {
            if (isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $key; // Anahtar bulunamadıysa anahtarı döndür
            }
        }
        
        // Parametreleri değiştir
        if (!empty($params) && is_string($value)) {
            foreach ($params as $param => $replacement) {
                $value = str_replace(':' . $param, $replacement, $value);
            }
        }
        
        return $value;
    }
    
    public function getCurrentLang() {
        return $this->currentLang;
    }
    
    public function getSupportedLanguages() {
        return $this->supportedLanguages;
    }
    
    public function setLanguage($lang) {
        if (in_array($lang, $this->supportedLanguages)) {
            $this->currentLang = $lang;
            $_SESSION['lang'] = $lang;
            return true;
        }
        return false;
    }
    
    public function getLanguageName($code) {
        $names = [
            'tr' => 'Türkçe',
            'en' => 'English',
            'de' => 'Deutsch'
        ];
        return $names[$code] ?? $code;
    }
    
    public function getLanguageFlag($code) {
        $flags = [
            'tr' => '🇹🇷',
            'en' => '🇺🇸',
            'de' => '🇩🇪'
        ];
        return $flags[$code] ?? '';
    }
}
?>


<?php

enum Workspaces : string {
    case BLOG = 'blog';
    case CHAT = 'chat';
    case ADMIN = 'admin';
}

enum Actions : string{
    case VIEW = 'view';
    case EDIT = 'edit';
    case DELETE = 'delete';
    case ADD = 'add';
}

enum Views : string {
    case HOME = 'index';
    case ABOUT = 'about';
    case ERROR = '404';

    public function getFile() {
        return ['baseName' => $this->value, 'name' => $this->fileName(), 'path' => $this->filePath(), 'ext' => VIEW_EXT];
    }

    private function getFileBasename() : string {
        return match($this) {
            self::HOME => "index",
            self::ABOUT => "about",
            self::ERROR => "404",
        };
    }
    private function fileName() : string {
            return $this->getFileBasename() . "html";
    }

    private function filePath() : string {
        return VIEW_PATH . $this->value . VIEW_EXT;
    }
}



define("CONTROLLER_PATH", "./src/controllers/");
define("VIEW_PATH", "./src/views/");
define("MODEL_PATH", "./src/models/");

define("VIEW_EXT", ".html");

define("VIEW_404", "404.html");
define("VIEW_HOME_", "index.html");
define("VIEW_ABOUT", "about.html");


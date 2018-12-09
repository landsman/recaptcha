# reCAPTCHA for Sunlight CMS 8.x

steps to install via composer:

1. add deplendency for filescopier (if you don't have them already) 

`composer require sasedev/composer-plugin-filecopier`

2. add recaptcha plugin folder to your project, example result:

```
{
  "name": "jdanek/web",
  "type": "project",
  "description": "my site with composer",
  "homepage": "https://www.jdanek.eu",
  "private": true,
  "require": {
    "php": ">=5.6.0",
    "sasedev/composer-plugin-filecopier": "^1.1"
  },
  "extra": {
    "filescopier": [
      {
        "source": "vendor/jdanek/recaptcha/plugins",
        "destination": "plugins",
        "debug": "true"
      }
    ]
  },
  "minimum-stability": "dev",
  "prefer-stable": true,      
  "config": {
    "bin-dir": "bin/",
    "discard-changes": true
  }
}
```

4. type for plugin install: 

`composer install jdanek/recaptcha master-dev`

5. create (edit) file .gitignore in project root contains:

```
# composer plugins
plugins/extend/recaptcha 
```

6. yeah and you have composer plugin your lucky human!


---


inspired by [studioartcz/sl_composer](https://github.com/studioartcz/sl_composer)
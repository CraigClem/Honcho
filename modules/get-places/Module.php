<?php

namespace modules\getplaces;

use Craft;
use yii\base\Module as BaseModule;
use craft\web\twig\variables\CraftVariable;
use yii\base\Event;
use modules\getplaces\services\PlacesService;
use modules\getplaces\variables\PlacesVariable;

/**
 * get-places module
 *
 * @method static Module getInstance()
 */
class Module extends BaseModule
{
    public function init(): void
    {
        Craft::setAlias('@modules/getplaces', __DIR__);

        // Set the controllerNamespace based on whether this is a console or web request
        if (Craft::$app->request->isConsoleRequest) {
            $this->controllerNamespace = 'modules\\getplaces\\console\\controllers';
        } else {
            $this->controllerNamespace = 'modules\\getplaces\\controllers';
        }

        parent::init();

        // Defer most setup tasks until Craft is fully initialized
        Craft::$app->onInit(function() {
            $this->attachEventHandlers();
            $this->setComponents([
            'places' => PlacesService::class,
        ]);

        });

        
    }

    private function attachEventHandlers(): void
    {

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('places', TweetVariable::class);
            }
        );
        // Register event handlers here ...
        // (see https://craftcms.com/docs/4.x/extend/events.html to get started)
    }
}

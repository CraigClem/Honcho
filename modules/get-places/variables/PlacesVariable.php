<?php

namespace modules\getplaces\variables;

use modules\getplaces\Module;

class PlacesVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param int $amount
     * @param mixed $fields
     * @param string $params
     * @return array
     */
    public function places(string $id = ''): array
    {       //look up  below for module

        $place = Module::$plugin->places->getPlaces($id);

        return $place;
    }
}

//

// {{places(id)}}


// places id from cms backend user adds
// function places
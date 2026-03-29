<?php

namespace IlBronza\Clients\Http\Parameters\Fieldsets;

class DestinationEditFieldsetsParameters extends DestinationShowFieldsetsParameters
{
    // emotional_image è definito in DestinationShowFieldsetsParameters
    // e viene usato sia per edit (upload) che per show (visualizzazione)
    // DestinationCreateStoreFieldsetsParameters lo esclude per create
}

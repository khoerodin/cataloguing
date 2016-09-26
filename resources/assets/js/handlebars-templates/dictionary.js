Handlebars.registerPartial("ontent", Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<div class=\"container2\">\n    <div class=\"page-header\">\n        <h2>DICTIONARY <small>ITEM NAME</small></h2>\n    </div>\n    <ul class=\"nav nav-tabs\" id=\"dictTab\">\n        <li class=\"active\"><a href=\"#item_name_tab\">ITEM NAME</a></li>\n        <li><a href=\"#group_class_tab\">GROUP CLASS</a></li>\n        <li><a href=\"#manufacturer_tab\">MANUFACTURER</a></li>\n        <li><a href=\"#unit_of_measurement_tab\">UNIT OF MEASUREMENT</a></li>\n        <li><a href=\"#abbreviation_tab\">ABBREVIATION</a></li>\n    </ul>\n    <div class=\"tab-content\">\n        <div role=\"tabpanel\" class=\"tab-pane active row\" id=\"item_name_tab\">\n            <div class=\"col-xs-2\">\n                <strong>INC</strong>\n                <input type=\"text\" placeholder=\"ALL INC\" id=\"inc_item_name_tab\" class=\"form-control input-sm\">\n            </div>\n            <div class=\"col-xs-2\">\n                <strong>ITEM NAME</strong>\n                <input type=\"text\" placeholder=\"ALL ITEM NAME\" id=\"item_name_item_name_tab\" class=\"form-control input-sm\">\n            </div>\n            <div class=\"col-xs-2\">\n                <strong>COLLOQUIAL</strong>\n                <select id=\"colloquial_item_name_tab\" class=\"colloquial-item-name-tab with-ajax\"  data-live-search=\"true\" data-width=\"100%\"></select>\n            </div>\n            <div class=\"col-xs-2\">\n                <strong>CHARACTERISTIC</strong>\n                <select id=\"characteristic_item_name_tab\" class=\"characteristic-item-name-tab with-ajax\"  data-live-search=\"true\" data-width=\"100%\"></select>\n            </div>\n            <div class=\"col-xs-2\" id=\"select_group_item_name_tab\">\n                <strong>GROUP</strong>\n                <select id=\"group_item_name_tab\" class=\"group-item-name-tab with-ajax\"  data-live-search=\"true\" data-width=\"100%\"></select>\n            </div>\n            <div class=\"col-xs-2\" id=\"select_class_item_name_tab\">\n                <strong>CLASS</strong>\n                <select id=\"class_item_name_tab\" class=\"class-item-name-tab with-ajax\"  data-live-search=\"true\" data-width=\"100%\"></select>\n            </div>\n            <div class=\"col-xs-12\">\n                <hr/>\n            </div>\n            <div class=\"col-xs-4\">\n                <table id=\"item_name_table\" class=\"table table-striped table-hover\" width=\"100%\" cellpadding=\"0\">\n                    <thead>\n                        <tr>\n                            <th>INC</th>\n                            <th>ITEM NAME</th>\n                        </tr>\n                    </thead>\n                </table>\n            </div>\n            <div class=\"col-xs-4\">\n                <div id=\"carousel-example-generic\" class=\"carousel slide\" data-ride=\"carousel\">\n                    <!-- Indicators -->\n                    <ol class=\"carousel-indicators\">\n                        <li data-target=\"#carousel-example-generic\" data-slide-to=\"0\" class=\"active\"></li>\n                        <li data-target=\"#carousel-example-generic\" data-slide-to=\"1\"></li>\n                        <li data-target=\"#carousel-example-generic\" data-slide-to=\"2\"></li>\n                    </ol>\n                    <!-- Wrapper for slides -->\n                    <div class=\"carousel-inner\" role=\"listbox\">\n                        <div class=\"item active\">\n                            <img src=\"#\" alt=\"...\">\n                            <div class=\"carousel-caption\">\n                                ...\n                            </div>\n                        </div>\n                        <div class=\"item\">\n                            <img src=\"#\" alt=\"...\">\n                            <div class=\"carousel-caption\">\n                                ...\n                            </div>\n                        </div>\n                        ...\n                    </div>\n                    <!-- Controls -->\n                    <a class=\"left carousel-control\" href=\"#carousel-example-generic\" role=\"button\" data-slide=\"prev\">\n                    <span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span>\n                    <span class=\"sr-only\">Previous</span>\n                    </a>\n                    <a class=\"right carousel-control\" href=\"#carousel-example-generic\" role=\"button\" data-slide=\"next\">\n                    <span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span>\n                    <span class=\"sr-only\">Next</span>\n                    </a>\n                </div>\n            </div>\n            <div class=\"col-xs-4\">\n                <ul class=\"nav nav-tabs\" id=\"dictTab\">\n                    <li class=\"active\"><a href=\"#eng_definition_sub_tab\">ENG DEFINITION</a></li>\n                    <li><a href=\"#ind_definition_sub_tab\">IND DEFINITION</a></li>\n                    <li><a href=\"#colloquial_sub_tab\">COLLOQUIAL</a></li>\n                </ul>\n                <div class=\"tab-content\">\n                    <div role=\"tabpanel\" class=\"tab-pane active row\" id=\"eng_definition_sub_tab\">\n                        <div class=\"col-xs-12\" id=\"eng_def_item_name_tab\"></div>\n                    </div>\n                    <div role=\"tabpanel\" class=\"tab-pane row\" id=\"ind_definition_sub_tab\">\n                        <div class=\"col-xs-12\" id=\"ind_def_item_name_tab\"></div>\n                    </div>\n                    <div role=\"tabpanel\" class=\"tab-pane row\" id=\"colloquial_sub_tab\">\n                        <div class=\"col-xs-12\">\n                            <div class=\"col-xs-12\"><button onClick=\"addColloquial()\" class=\"btn btn-xs btn-primary pull-right\" style=\"margin-top:5px;\"><i class=\"fa fa-plus\"></i>&nbsp;&nbsp;ADD NEW</button></div>\n                            <table id=\"colloquial_table_item_name_tab\" class=\"table table-striped table-hover\" width=\"100%\" cellpadding=\"0\">\n                                <thead>\n                                    <tr>\n                                        <th>COLLOQUIAL</th>\n                                    </tr>\n                                </thead>\n                            </table>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n        <div role=\"tabpanel\" class=\"tab-pane row\" id=\"group_class_tab\">\n            <div class=\"col-xs-12\">\n                GROUP CLASS\n            </div>\n        </div>\n        <div role=\"tabpanel\" class=\"tab-pane row\" id=\"manufacturer_tab\">\n            <div class=\"col-xs-12\">\n                MANUFACTURER\n            </div>\n        </div>\n        <div role=\"tabpanel\" class=\"tab-pane row\" id=\"unit_of_measurement_tab\">\n            <div class=\"col-xs-12\">\n                UNIT OF MEASUREMENT\n            </div>\n        </div>\n        <div role=\"tabpanel\" class=\"tab-pane row\" id=\"abbreviation_tab\">\n            <div class=\"col-xs-12\">\n                ABBREVIATION\n            </div>\n        </div>\n    </div>\n</div>";
},"useData":true}));
this["Dictionary"] = this["Dictionary"] || {};
this["Dictionary"]["templates"] = this["Dictionary"]["templates"] || {};
this["Dictionary"]["templates"]["content"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<div class=\"container2\">\n    <div class=\"page-header\">\n        <h2>DICTIONARY <small>ITEM NAME</small></h2>\n    </div>\n    <ul class=\"nav nav-tabs\" id=\"dictTab\">\n        <li class=\"active\"><a href=\"#item_name_tab\">ITEM NAME</a></li>\n        <li><a href=\"#group_class_tab\">GROUP CLASS</a></li>\n        <li><a href=\"#manufacturer_tab\">MANUFACTURER</a></li>\n        <li><a href=\"#unit_of_measurement_tab\">UNIT OF MEASUREMENT</a></li>\n        <li><a href=\"#abbreviation_tab\">ABBREVIATION</a></li>\n    </ul>\n    <div class=\"tab-content\">\n        <div role=\"tabpanel\" class=\"tab-pane active row\" id=\"item_name_tab\">\n            <div class=\"col-xs-2\">\n                <strong>INC</strong>\n                <input type=\"text\" placeholder=\"ALL INC\" id=\"inc_item_name_tab\" class=\"form-control input-sm\">\n            </div>\n            <div class=\"col-xs-2\">\n                <strong>ITEM NAME</strong>\n                <input type=\"text\" placeholder=\"ALL ITEM NAME\" id=\"item_name_item_name_tab\" class=\"form-control input-sm\">\n            </div>\n            <div class=\"col-xs-2\">\n                <strong>COLLOQUIAL</strong>\n                <select id=\"colloquial_item_name_tab\" class=\"colloquial-item-name-tab with-ajax\"  data-live-search=\"true\" data-width=\"100%\"></select>\n            </div>\n            <div class=\"col-xs-2\">\n                <strong>CHARACTERISTIC</strong>\n                <select id=\"characteristic_item_name_tab\" class=\"characteristic-item-name-tab with-ajax\"  data-live-search=\"true\" data-width=\"100%\"></select>\n            </div>\n            <div class=\"col-xs-2\" id=\"select_group_item_name_tab\">\n                <strong>GROUP</strong>\n                <select id=\"group_item_name_tab\" class=\"group-item-name-tab with-ajax\"  data-live-search=\"true\" data-width=\"100%\"></select>\n            </div>\n            <div class=\"col-xs-2\" id=\"select_class_item_name_tab\">\n                <strong>CLASS</strong>\n                <select id=\"class_item_name_tab\" class=\"class-item-name-tab with-ajax\"  data-live-search=\"true\" data-width=\"100%\"></select>\n            </div>\n            <div class=\"col-xs-12\">\n                <hr/>\n            </div>\n            <div class=\"col-xs-4\">\n                <table id=\"item_name_table\" class=\"table table-striped table-hover\" width=\"100%\" cellpadding=\"0\">\n                    <thead>\n                        <tr>\n                            <th>INC</th>\n                            <th>ITEM NAME</th>\n                        </tr>\n                    </thead>\n                </table>\n            </div>\n            <div class=\"col-xs-4\">\n                <div id=\"carousel-example-generic\" class=\"carousel slide\" data-ride=\"carousel\">\n                    <!-- Indicators -->\n                    <ol class=\"carousel-indicators\">\n                        <li data-target=\"#carousel-example-generic\" data-slide-to=\"0\" class=\"active\"></li>\n                        <li data-target=\"#carousel-example-generic\" data-slide-to=\"1\"></li>\n                        <li data-target=\"#carousel-example-generic\" data-slide-to=\"2\"></li>\n                    </ol>\n                    <!-- Wrapper for slides -->\n                    <div class=\"carousel-inner\" role=\"listbox\">\n                        <div class=\"item active\">\n                            <img src=\"#\" alt=\"...\">\n                            <div class=\"carousel-caption\">\n                                ...\n                            </div>\n                        </div>\n                        <div class=\"item\">\n                            <img src=\"#\" alt=\"...\">\n                            <div class=\"carousel-caption\">\n                                ...\n                            </div>\n                        </div>\n                        ...\n                    </div>\n                    <!-- Controls -->\n                    <a class=\"left carousel-control\" href=\"#carousel-example-generic\" role=\"button\" data-slide=\"prev\">\n                    <span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span>\n                    <span class=\"sr-only\">Previous</span>\n                    </a>\n                    <a class=\"right carousel-control\" href=\"#carousel-example-generic\" role=\"button\" data-slide=\"next\">\n                    <span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span>\n                    <span class=\"sr-only\">Next</span>\n                    </a>\n                </div>\n            </div>\n            <div class=\"col-xs-4\">\n                <ul class=\"nav nav-tabs\" id=\"dictTab\">\n                    <li class=\"active\"><a href=\"#eng_definition_sub_tab\">ENG DEFINITION</a></li>\n                    <li><a href=\"#ind_definition_sub_tab\">IND DEFINITION</a></li>\n                    <li><a href=\"#colloquial_sub_tab\">COLLOQUIAL</a></li>\n                </ul>\n                <div class=\"tab-content\">\n                    <div role=\"tabpanel\" class=\"tab-pane active row\" id=\"eng_definition_sub_tab\">\n                        <div class=\"col-xs-12\" id=\"eng_def_item_name_tab\"></div>\n                    </div>\n                    <div role=\"tabpanel\" class=\"tab-pane row\" id=\"ind_definition_sub_tab\">\n                        <div class=\"col-xs-12\" id=\"ind_def_item_name_tab\"></div>\n                    </div>\n                    <div role=\"tabpanel\" class=\"tab-pane row\" id=\"colloquial_sub_tab\">\n                        <div class=\"col-xs-12\">\n                            <div class=\"col-xs-12\"><button onClick=\"addColloquial()\" class=\"btn btn-xs btn-primary pull-right\" style=\"margin-top:5px;\"><i class=\"fa fa-plus\"></i>&nbsp;&nbsp;ADD NEW</button></div>\n                            <table id=\"colloquial_table_item_name_tab\" class=\"table table-striped table-hover\" width=\"100%\" cellpadding=\"0\">\n                                <thead>\n                                    <tr>\n                                        <th>COLLOQUIAL</th>\n                                    </tr>\n                                </thead>\n                            </table>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n        <div role=\"tabpanel\" class=\"tab-pane row\" id=\"group_class_tab\">\n            <div class=\"col-xs-12\">\n                GROUP CLASS\n            </div>\n        </div>\n        <div role=\"tabpanel\" class=\"tab-pane row\" id=\"manufacturer_tab\">\n            <div class=\"col-xs-12\">\n                MANUFACTURER\n            </div>\n        </div>\n        <div role=\"tabpanel\" class=\"tab-pane row\" id=\"unit_of_measurement_tab\">\n            <div class=\"col-xs-12\">\n                UNIT OF MEASUREMENT\n            </div>\n        </div>\n        <div role=\"tabpanel\" class=\"tab-pane row\" id=\"abbreviation_tab\">\n            <div class=\"col-xs-12\">\n                ABBREVIATION\n            </div>\n        </div>\n    </div>\n</div>";
},"useData":true});
Handlebars.registerPartial("avbar", Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<nav class=\"navbar navbar-default navbar-fixed-top\">\n    <div class=\"container-fluid\">\n        <div class=\"navbar-header\">\n            <a class=\"navbar-brand\" href=\"/\"><strong>CATALOG Web App</strong></a>\n        </div>\n        <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">\n            <ul class=\"nav navbar-nav\">\n                <li class=\"dropdown active\">\n                    <a href=\"/dictionary\">DICTIONARY</a>\n                </li>\n                <li class=\"dropdown\">\n                    <a href=\"/settings\">SETTINGS</a>\n                </li>\n                <li class=\"dropdown\">\n                    <a href=\"/tools\">TOOLS</a>\n                </li>\n            </ul>\n            <ul class=\"nav navbar-nav navbar-right\">\n                <input type=\"hidden\" value=\"5\" id=\"logged_in_user\">\n                <li class=\"dropdown\">\n                    <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Guest <span class=\"caret\"></span></a>\n                    <ul class=\"dropdown-menu\" role=\"menu\">\n                        <li>\n                            <a href=\"#\" id=\"logoutapp\">Logout</a>\n                        </li>\n                    </ul>\n                </li>\n            </ul>\n        </div>\n    </div>\n</nav>";
},"useData":true}));
this["Dictionary"]["templates"]["navbar"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    return "<nav class=\"navbar navbar-default navbar-fixed-top\">\n    <div class=\"container-fluid\">\n        <div class=\"navbar-header\">\n            <a class=\"navbar-brand\" href=\"/\"><strong>CATALOG Web App</strong></a>\n        </div>\n        <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">\n            <ul class=\"nav navbar-nav\">\n                <li class=\"dropdown active\">\n                    <a href=\"/dictionary\">DICTIONARY</a>\n                </li>\n                <li class=\"dropdown\">\n                    <a href=\"/settings\">SETTINGS</a>\n                </li>\n                <li class=\"dropdown\">\n                    <a href=\"/tools\">TOOLS</a>\n                </li>\n            </ul>\n            <ul class=\"nav navbar-nav navbar-right\">\n                <input type=\"hidden\" value=\"5\" id=\"logged_in_user\">\n                <li class=\"dropdown\">\n                    <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Guest <span class=\"caret\"></span></a>\n                    <ul class=\"dropdown-menu\" role=\"menu\">\n                        <li>\n                            <a href=\"#\" id=\"logoutapp\">Logout</a>\n                        </li>\n                    </ul>\n                </li>\n            </ul>\n        </div>\n    </div>\n</nav>";
},"useData":true});
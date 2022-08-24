    <!-- this file should be at /views/templates/hook/displayshippingmethods.tpl -->
    <!-- Block displayshippingmethods -->
    <div class="block-contact col-md-3 links wrapper shipping-methods">
        <div class="col-md-8">
            <div class="row">
                <div class="title clearfix hidden-md-up collapsed" id="shipping-methods-target" data-target="#shipping-methods" data-toggle="collapse" aria-expanded="false">
                    <span class="h3">{$shipping_methods_title|escape:'html':'UTF-8'}</span>
                    <span class="float-xs-right">
                        <span class="navbar-toggler collapse-icons">
                            <i class="material-icons add">keyboard_arrow_down</i>
                            <i class="material-icons remove">keyboard_arrow_up</i>
                        </span>
                    </span>
                </div>
                <p class="h4 text-uppercase block-contact-title hidden-sm-down">{$shipping_methods_title|escape:'html':'UTF-8'}</p>
                <div id="shipping-methods" class="collapse">
                    <ul>
                        {foreach $shipping_methods_list as $carrier}
                        <li><img src={"/Botiga/img/s/"|cat:$carrier["id_carrier"]|cat:".jpg"}  width="35" alt="logo"> {$carrier["name"]} {if $carrier["name"]}-{/if} {$carrier["delay"]}</li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        </div>
    </div>
  <!-- /Block displayshippingmethods -->

  
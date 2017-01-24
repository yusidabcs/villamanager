<div class="row">
          <div class="col-md-6">

            <div class="form-group">
              <label for="villa_id">Select Villa</label>
              <br>
              <select class="form-control" name="villa_id" required style="width: 100%">
                <option value="">Select Villa</option>
                @foreach($villas as $villa)
                <option value="{{ $villa->id }}" {{ old('villa') == $villa->id ? 'selected' : '' }} data-url="{{ url('villamanagers/bookingdate/'.$villa->id)  }}" > {{ $villa->name }} </option>
                @endforeach
              </select>
            </div>

          </div>
          <div class="col-md-6">

            <div class="form-group">
              <label for="exampleInputEmail1">Total Guest</label>
              <input type="number" class="form-control" id="exampleInputEmail1" name="adult_guest" placeholder="Total guest" required="" min="1">
            </div>

          </div>
        </div>


        <div class="row">
          <div class="col-md-6">

            <div class="form-group">
              <label for="exampleInputEmail1">Check in</label>
              <input type="text" class="form-control" placeholder="Check in" id="check_in" name="check_in" required="">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Check Out</label>
              <input type="text" class="form-control" placeholder="Check out" id="check_out" name="check_out" required="">
            </div>

          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-4">

            <div class="form-group">
              <label style="display: block;">Title</label>
              <label class="radio-inline">
                <input type="radio" name="title" required="" value="Mr">Mr.
              </label>
              <label class="radio-inline">
                <input type="radio" name="title" required value="Ms">Ms.
              </label>
              <label class="radio-inline">
                <input type="radio" name="title" required value="Mrs">Mrs.
              </label>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputEmail1">First Name</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="First name" name="first_name" required>
            </div>

          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputEmail1">Last Name</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Last name" name="last_name" required>
            </div>

          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputEmail1">Phone</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Phone" name="phone" required>
            </div>

          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputEmail1">Country</label>
              <select name="country" class="form-control"  required="" style="width:100%">
                  <option value="">
                      -- Select country --
                  </option>
                  <option value="xa" data-prefix="">
                      Abkhazia, Georgia
                  </option>
                  <option value="af" data-prefix="">
                      Afghanistan
                  </option>
                  <option value="al" data-prefix="">
                      Albania
                  </option>
                  <option value="dz" data-prefix="">
                      Algeria
                  </option>
                  <option value="as" data-prefix="">
                      American Samoa
                  </option>
                  <option value="ad" data-prefix="">
                      Andorra
                  </option>
                  <option value="ao" data-prefix="">
                      Angola
                  </option>
                  <option value="ai" data-prefix="">
                      Anguilla
                  </option>
                  <option value="aq" data-prefix="">
                      Antarctica
                  </option>
                  <option value="ag" data-prefix="">
                      Antigua &amp; Barbuda
                  </option>
                  <option value="ar" data-prefix="">
                      Argentina
                  </option>
                  <option value="am" data-prefix="">
                      Armenia
                  </option>
                  <option value="aw" data-prefix="">
                      Aruba
                  </option>
                  <option value="au" data-prefix="">
                      Australia
                  </option>
                  <option value="at" data-prefix="">
                      Austria
                  </option>
                  <option value="az" data-prefix="">
                      Azerbaijan
                  </option>
                  <option value="bs" data-prefix="">
                      Bahamas
                  </option>
                  <option value="bh" data-prefix="">
                      Bahrain
                  </option>
                  <option value="bd" data-prefix="">
                      Bangladesh
                  </option>
                  <option value="bb" data-prefix="">
                      Barbados
                  </option>
                  <option value="by" data-prefix="">
                      Belarus
                  </option>
                  <option value="be" data-prefix="">
                      Belgium
                  </option>
                  <option value="bz" data-prefix="">
                      Belize
                  </option>
                  <option value="bj" data-prefix="">
                      Benin
                  </option>
                  <option value="bm" data-prefix="">
                      Bermuda
                  </option>
                  <option value="bt" data-prefix="">
                      Bhutan
                  </option>
                  <option value="bo" data-prefix="">
                      Bolivia
                  </option>
                  <option value="bq" data-prefix="">
                      Bonaire St Eustatius and Saba
                  </option>
                  <option value="ba" data-prefix="">
                      Bosnia and Herzegovina
                  </option>
                  <option value="bw" data-prefix="">
                      Botswana
                  </option>
                  <option value="bv" data-prefix="">
                      Bouvet Island
                  </option>
                  <option value="br" data-prefix="">
                      Brazil
                  </option>
                  <option value="io" data-prefix="">
                      British Indian Ocean Territory
                  </option>
                  <option value="bn" data-prefix="">
                      Brunei Darussalam
                  </option>
                  <option value="bg" data-prefix="">
                      Bulgaria
                  </option>
                  <option value="bf" data-prefix="">
                      Burkina Faso
                  </option>
                  <option value="bi" data-prefix="">
                      Burundi
                  </option>
                  <option value="kh" data-prefix="">
                      Cambodia
                  </option>
                  <option value="cm" data-prefix="">
                      Cameroon
                  </option>
                  <option value="ca" data-prefix="">
                      Canada
                  </option>
                  <option value="cv" data-prefix="">
                      Cape Verde
                  </option>
                  <option value="ky" data-prefix="">
                      Cayman Islands
                  </option>
                  <option value="cf" data-prefix="">
                      Central Africa Republic
                  </option>
                  <option value="td" data-prefix="">
                      Chad
                  </option>
                  <option value="cl" data-prefix="">
                      Chile
                  </option>
                  <option value="cn" data-prefix="">
                      China
                  </option>
                  <option value="cx" data-prefix="">
                      Christmas Island
                  </option>
                  <option value="cc" data-prefix="">
                      Cocos (K) I.
                  </option>
                  <option value="co" data-prefix="">
                      Colombia
                  </option>
                  <option value="km" data-prefix="">
                      Comoros
                  </option>
                  <option value="cg" data-prefix="">
                      Congo
                  </option>
                  <option value="ck" data-prefix="">
                      Cook Islands
                  </option>
                  <option value="cr" data-prefix="">
                      Costa Rica
                  </option>
                  <option value="xc" data-prefix="">
                      Crimea
                  </option>
                  <option value="hr" data-prefix="">
                      Croatia
                  </option>
                  <option value="cw" data-prefix="">
                      Curaçao
                  </option>
                  <option value="cy" data-prefix="">
                      Cyprus
                  </option>
                  <option value="cz" data-prefix="">
                      Czech Republic
                  </option>
                  <option value="ci" data-prefix="">
                      Côte d'Ivoire
                  </option>
                  <option value="cd" data-prefix="">
                      Democratic Republic of Congo
                  </option>
                  <option value="dk" data-prefix="">
                      Denmark
                  </option>
                  <option value="dj" data-prefix="">
                      Djibouti
                  </option>
                  <option value="dm" data-prefix="">
                      Dominica
                  </option>
                  <option value="do" data-prefix="">
                      Dominican Republic
                  </option>
                  <option value="tl" data-prefix="">
                      East Timor
                  </option>
                  <option value="ec" data-prefix="">
                      Ecuador
                  </option>
                  <option value="eg" data-prefix="">
                      Egypt
                  </option>
                  <option value="sv" data-prefix="">
                      El Salvador
                  </option>
                  <option value="gq" data-prefix="">
                      Equatorial Guinea
                  </option>
                  <option value="er" data-prefix="">
                      Eritrea
                  </option>
                  <option value="ee" data-prefix="">
                      Estonia
                  </option>
                  <option value="et" data-prefix="">
                      Ethiopia
                  </option>
                  <option value="fk" data-prefix="">
                      Falkland Islands (Malvinas)
                  </option>
                  <option value="fo" data-prefix="">
                      Faroe Islands
                  </option>
                  <option value="fj" data-prefix="">
                      Fiji
                  </option>
                  <option value="fi" data-prefix="">
                      Finland
                  </option>
                  <option value="fr" data-prefix="">
                      France
                  </option>
                  <option value="gf" data-prefix="">
                      French Guiana
                  </option>
                  <option value="pf" data-prefix="">
                      French Polynesia
                  </option>
                  <option value="tf" data-prefix="">
                      French Southern Territories
                  </option>
                  <option value="ga" data-prefix="">
                      Gabon
                  </option>
                  <option value="gm" data-prefix="">
                      Gambia
                  </option>
                  <option value="ge" data-prefix="">
                      Georgia
                  </option>
                  <option value="de" data-prefix="">
                      Germany
                  </option>
                  <option value="gh" data-prefix="">
                      Ghana
                  </option>
                  <option value="gi" data-prefix="">
                      Gibraltar
                  </option>
                  <option value="gr" data-prefix="">
                      Greece
                  </option>
                  <option value="gl" data-prefix="">
                      Greenland
                  </option>
                  <option value="gd" data-prefix="">
                      Grenada
                  </option>
                  <option value="gp" data-prefix="">
                      Guadeloupe
                  </option>
                  <option value="gu" data-prefix="">
                      Guam
                  </option>
                  <option value="gt" data-prefix="">
                      Guatemala
                  </option>
                  <option value="gg" data-prefix="">
                      Guernsey
                  </option>
                  <option value="gn" data-prefix="">
                      Guinea
                  </option>
                  <option value="gw" data-prefix="">
                      Guinea-Bissau
                  </option>
                  <option value="gy" data-prefix="">
                      Guyana
                  </option>
                  <option value="ht" data-prefix="">
                      Haiti
                  </option>
                  <option value="hm" data-prefix="">
                      Heard and McDonald Islands
                  </option>
                  <option value="hn" data-prefix="">
                      Honduras
                  </option>
                  <option value="hk" data-prefix="">
                      Hong Kong
                  </option>
                  <option value="hu" data-prefix="">
                      Hungary
                  </option>
                  <option value="is" data-prefix="">
                      Iceland
                  </option>
                  <option value="in" data-prefix="">
                      India
                  </option>
                  <option value="id" data-prefix="" selected="selected">
                      Indonesia
                  </option>
                  <option value="ir" data-prefix="">
                      Iran
                  </option>
                  <option value="iq" data-prefix="">
                      Iraq
                  </option>
                  <option value="ie" data-prefix="">
                      Ireland
                  </option>
                  <option value="im" data-prefix="">
                      Isle of Man
                  </option>
                  <option value="il" data-prefix="">
                      Israel
                  </option>
                  <option value="it" data-prefix="">
                      Italy
                  </option>
                  <option value="jm" data-prefix="">
                      Jamaica
                  </option>
                  <option value="jp" data-prefix="">
                      Japan
                  </option>
                  <option value="je" data-prefix="">
                      Jersey
                  </option>
                  <option value="jo" data-prefix="">
                      Jordan
                  </option>
                  <option value="kz" data-prefix="">
                      Kazakhstan
                  </option>
                  <option value="ke" data-prefix="">
                      Kenya
                  </option>
                  <option value="ki" data-prefix="">
                      Kiribati
                  </option>
                  <option value="xk" data-prefix="">
                      Kosovo
                  </option>
                  <option value="kw" data-prefix="">
                      Kuwait
                  </option>
                  <option value="kg" data-prefix="">
                      Kyrgyzstan
                  </option>
                  <option value="la" data-prefix="">
                      Laos
                  </option>
                  <option value="lv" data-prefix="">
                      Latvia
                  </option>
                  <option value="lb" data-prefix="">
                      Lebanon
                  </option>
                  <option value="ls" data-prefix="">
                      Lesotho
                  </option>
                  <option value="lr" data-prefix="">
                      Liberia
                  </option>
                  <option value="ly" data-prefix="">
                      Libya
                  </option>
                  <option value="li" data-prefix="">
                      Liechtenstein
                  </option>
                  <option value="lt" data-prefix="">
                      Lithuania
                  </option>
                  <option value="lu" data-prefix="">
                      Luxembourg
                  </option>
                  <option value="mo" data-prefix="">
                      Macao
                  </option>
                  <option value="mk" data-prefix="">
                      Macedonia
                  </option>
                  <option value="mg" data-prefix="">
                      Madagascar
                  </option>
                  <option value="mw" data-prefix="">
                      Malawi
                  </option>
                  <option value="my" data-prefix="">
                      Malaysia
                  </option>
                  <option value="mv" data-prefix="">
                      Maldives
                  </option>
                  <option value="ml" data-prefix="">
                      Mali
                  </option>
                  <option value="mt" data-prefix="">
                      Malta
                  </option>
                  <option value="mh" data-prefix="">
                      Marshall Islands
                  </option>
                  <option value="mq" data-prefix="">
                      Martinique
                  </option>
                  <option value="mr" data-prefix="">
                      Mauritania
                  </option>
                  <option value="mu" data-prefix="">
                      Mauritius
                  </option>
                  <option value="yt" data-prefix="">
                      Mayotte
                  </option>
                  <option value="mx" data-prefix="">
                      Mexico
                  </option>
                  <option value="fm" data-prefix="">
                      Micronesia
                  </option>
                  <option value="md" data-prefix="">
                      Moldova
                  </option>
                  <option value="mc" data-prefix="">
                      Monaco
                  </option>
                  <option value="mn" data-prefix="">
                      Mongolia
                  </option>
                  <option value="me" data-prefix="">
                      Montenegro
                  </option>
                  <option value="ms" data-prefix="">
                      Montserrat
                  </option>
                  <option value="ma" data-prefix="">
                      Morocco
                  </option>
                  <option value="mz" data-prefix="">
                      Mozambique
                  </option>
                  <option value="mm" data-prefix="">
                      Myanmar
                  </option>
                  <option value="na" data-prefix="">
                      Namibia
                  </option>
                  <option value="nr" data-prefix="">
                      Nauru
                  </option>
                  <option value="np" data-prefix="">
                      Nepal
                  </option>
                  <option value="nl" data-prefix="">
                      Netherlands
                  </option>
                  <option value="nc" data-prefix="">
                      New Caledonia
                  </option>
                  <option value="nz" data-prefix="">
                      New Zealand
                  </option>
                  <option value="ni" data-prefix="">
                      Nicaragua
                  </option>
                  <option value="ne" data-prefix="">
                      Niger
                  </option>
                  <option value="ng" data-prefix="">
                      Nigeria
                  </option>
                  <option value="nu" data-prefix="">
                      Niue
                  </option>
                  <option value="nf" data-prefix="">
                      Norfolk Island
                  </option>
                  <option value="kp" data-prefix="">
                      North Korea
                  </option>
                  <option value="mp" data-prefix="">
                      Northern Mariana Islands
                  </option>
                  <option value="no" data-prefix="">
                      Norway
                  </option>
                  <option value="om" data-prefix="">
                      Oman
                  </option>
                  <option value="pk" data-prefix="">
                      Pakistan
                  </option>
                  <option value="pw" data-prefix="">
                      Palau
                  </option>
                  <option value="ps" data-prefix="">
                      Palestinian Territory
                  </option>
                  <option value="pa" data-prefix="">
                      Panama
                  </option>
                  <option value="pg" data-prefix="">
                      Papua New Guinea
                  </option>
                  <option value="py" data-prefix="">
                      Paraguay
                  </option>
                  <option value="pe" data-prefix="">
                      Peru
                  </option>
                  <option value="ph" data-prefix="">
                      Philippines
                  </option>
                  <option value="pn" data-prefix="">
                      Pitcairn
                  </option>
                  <option value="pl" data-prefix="">
                      Poland
                  </option>
                  <option value="pt" data-prefix="">
                      Portugal
                  </option>
                  <option value="pr" data-prefix="">
                      Puerto Rico
                  </option>
                  <option value="qa" data-prefix="">
                      Qatar
                  </option>
                  <option value="re" data-prefix="">
                      Reunion
                  </option>
                  <option value="ro" data-prefix="">
                      Romania
                  </option>
                  <option value="ru" data-prefix="">
                      Russia
                  </option>
                  <option value="rw" data-prefix="">
                      Rwanda
                  </option>
                  <option value="bl" data-prefix="">
                      Saint Barthelemy
                  </option>
                  <option value="kn" data-prefix="">
                      Saint Kitts and Nevis
                  </option>
                  <option value="lc" data-prefix="">
                      Saint Lucia
                  </option>
                  <option value="mf" data-prefix="">
                      Saint Martin
                  </option>
                  <option value="vc" data-prefix="">
                      Saint Vincent &amp; Grenadines
                  </option>
                  <option value="ws" data-prefix="">
                      Samoa
                  </option>
                  <option value="sm" data-prefix="">
                      San Marino
                  </option>
                  <option value="sa" data-prefix="">
                      Saudi Arabia
                  </option>
                  <option value="sn" data-prefix="">
                      Senegal
                  </option>
                  <option value="rs" data-prefix="">
                      Serbia
                  </option>
                  <option value="sc" data-prefix="">
                      Seychelles
                  </option>
                  <option value="sl" data-prefix="">
                      Sierra Leone
                  </option>
                  <option value="sg" data-prefix="">
                      Singapore
                  </option>
                  <option value="sx" data-prefix="">
                      Sint Maarten
                  </option>
                  <option value="sk" data-prefix="">
                      Slovakia
                  </option>
                  <option value="si" data-prefix="">
                      Slovenia
                  </option>
                  <option value="sb" data-prefix="">
                      Solomon Islands
                  </option>
                  <option value="so" data-prefix="">
                      Somalia
                  </option>
                  <option value="za" data-prefix="">
                      South Africa
                  </option>
                  <option value="gs" data-prefix="">
                      South Georgia and the South Sandwi…
                  </option>
                  <option value="kr" data-prefix="">
                      South Korea
                  </option>
                  <option value="ss" data-prefix="">
                      South Sudan
                  </option>
                  <option value="es" data-prefix="">
                      Spain
                  </option>
                  <option value="lk" data-prefix="">
                      Sri Lanka
                  </option>
                  <option value="sh" data-prefix="">
                      St Helena
                  </option>
                  <option value="pm" data-prefix="">
                      St Pierre and Miquelon
                  </option>
                  <option value="sd" data-prefix="">
                      Sudan
                  </option>
                  <option value="sr" data-prefix="">
                      Suriname
                  </option>
                  <option value="sj" data-prefix="">
                      Svalbard &amp; Jan Mayen
                  </option>
                  <option value="sz" data-prefix="">
                      Swaziland
                  </option>
                  <option value="se" data-prefix="">
                      Sweden
                  </option>
                  <option value="ch" data-prefix="">
                      Switzerland
                  </option>
                  <option value="sy" data-prefix="">
                      Syria
                  </option>
                  <option value="st" data-prefix="">
                      São Tomé and Príncipe
                  </option>
                  <option value="tw" data-prefix="">
                      Taiwan
                  </option>
                  <option value="tj" data-prefix="">
                      Tajikistan
                  </option>
                  <option value="tz" data-prefix="">
                      Tanzania
                  </option>
                  <option value="th" data-prefix="">
                      Thailand
                  </option>
                  <option value="tg" data-prefix="">
                      Togo
                  </option>
                  <option value="tk" data-prefix="">
                      Tokelau
                  </option>
                  <option value="to" data-prefix="">
                      Tonga
                  </option>
                  <option value="tt" data-prefix="">
                      Trinidad and Tobago
                  </option>
                  <option value="tn" data-prefix="">
                      Tunisia
                  </option>
                  <option value="tr" data-prefix="">
                      Turkey
                  </option>
                  <option value="tm" data-prefix="">
                      Turkmenistan
                  </option>
                  <option value="tc" data-prefix="">
                      Turks &amp; Caicos Islands
                  </option>
                  <option value="tv" data-prefix="">
                      Tuvalu
                  </option>
                  <option value="vg" data-prefix="">
                      UK Virgin Islands
                  </option>
                  <option value="vi" data-prefix="">
                      US Virgin Islands
                  </option>
                  <option value="us" data-prefix="">
                      USA
                  </option>
                  <option value="ug" data-prefix="">
                      Uganda
                  </option>
                  <option value="ua" data-prefix="">
                      Ukraine
                  </option>
                  <option value="ae" data-prefix="">
                      United Arab Emirates
                  </option>
                  <option value="gb" data-prefix="">
                      United Kingdom
                  </option>
                  <option value="um" data-prefix="">
                      United States Minor Outlying Islan…
                  </option>
                  <option value="uy" data-prefix="">
                      Uruguay
                  </option>
                  <option value="uz" data-prefix="">
                      Uzbekistan
                  </option>
                  <option value="vu" data-prefix="">
                      Vanuatu
                  </option>
                  <option value="va" data-prefix="">
                      Vatican City
                  </option>
                  <option value="ve" data-prefix="">
                      Venezuela
                  </option>
                  <option value="vn" data-prefix="">
                      Vietnam
                  </option>
                  <option value="wf" data-prefix="">
                      Wallis and Futuna
                  </option>
                  <option value="ye" data-prefix="">
                      Yemen
                  </option>
                  <option value="zm" data-prefix="">
                      Zambia
                  </option>
                  <option value="zw" data-prefix="">
                      Zimbabwe
                  </option>
              </select>
            </div>

          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputEmail1">Email</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email" required>
            </div>

          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col-md-6">

            <div class="form-group">
              <label for="exampleInputEmail1">Total Price</label>
              <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Total price" name="total" required="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Down Payment</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Down payment" name="total_paid" required>
            </div>

          </div>
        </div>


        <div class="row">
          <div class="col-md-6">

            <div class="form-group">
              <label for="exampleInputEmail1">Status</label>

              <div class="radio">
                <label>
                  <input type="radio" name="status" id="optionsRadios1" value="0" checked> Pending
                </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="status" id="optionsRadios2" value="1"> Paid
                </label>
              </div>
              <div class="radio disabled">
                <label>
                  <input type="radio" name="status" id="optionsRadios3" value="2" disabled> Cancel
                </label>
              </div>

            </div>
          </div>
        </div>
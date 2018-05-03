@extends('menu.index')
@section('content')

	 <div class="row">
          <div class="col-sm-12 p-0">
            <div class="main-header">
              <h4>Dashboard</h4>
            </div>
          </div>
        </div>


        <!-- 1-1 blocks row start -->
        <div class="row">
          <div class="col-lg-3">
            <div class="card dashboard-card-sm">
              <div class="card-header">
                  <h5 class="card-header-text">Total Venta del día</h5>
              </div>
              <div class="card-block">
                <div class="media d-flex">
                  <div class="mr-3">
                    <div class="new-orders">
                      <i class="icofont icofont-cur-dollar bg-success"></i>
                    </div>
                  </div>
                  <div class="media-body">
                      <span class="counter-txt f-w-600 f-20">
                        $  <span class="counter" id="totalVentaDia">00.000.000.-</span>
                        <h6 id="VentaDiaLocal">Elektrofertas: $ 00.000.000<br>ModaOfertas $ 00.000.000</h6>
                      </span>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <div class="col-lg-3">
            <div class="card dashboard-card-sm">
               <div class="card-header">
                  <h5 class="card-header-text"  id="totaSemana">Venta acumlada esta Semana</h5>
                </div>
              <div class="card-block">
                <div class="media d-flex order-counter">
                  <div class="mr-3">
                    <div class="new-orders">
                      <i class="icofont icofont-cur-dollar bg-warning"></i>
                    </div>
                  </div>
                  <div class="media-body">
                      <span class="counter-txt f-w-600 f-20">
                        $  <span class="counter" id="totalVentaSemana">00.000.000.-</span>
                        <h6 id="VentaSemanaLocal">Elektrofertas: $ 00.000.000<br>ModaOfertas $ 00.000.000</h6>
                      </span>
                  </div>
                </div>
                <ul>
                  <li class="new-users">

                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                  <h5 class="card-header-text" id="totalMes">Total Venta Mes EFMAMJJASOND</h5>
                </div>

              <div class="card-block">
                <div class="media d-flex order-counter">
                  <div class="mr-3">
                    <div class="new-orders">
                      <i class="icofont icofont-cur-dollar"></i>
                    </div>
                  </div>
                  <div class="media-body">
                      <span class="counter-txt">
                        $  <span class="counter" id="totalVentaMes">00.000.000.-</span>
                        <h6 id="VentaMesLocal">Elektrofertas: $ 00.000.000<br>ModaOfertas $ 00.000.000</h6>
                      </span>
                  </div>
                </div>
                <ul>
                  <li class="new-users"></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                  <h5 class="card-header-text" id="totalAgno">Total Venta Año 2000/h5>
                </div>

              <div class="card-block">
                <div class="media d-flex order-counter">
                  <div class="mr-3">
                    <div class="new-orders">
                      <i class="icofont icofont-cur-dollar bg-danger"></i>
                    </div>
                  </div>
                  <div class="media-body">
                      <span class="counter-txt">
                        $  <span class="counter" id="totalVentaAgno">00.000.000.-</span>
                        <h6 id="VentaAgnoLocal">Elektrofertas: $ 00.000.000<br>ModaOfertas $ 00.000.000</h6>
                      </span>
                  </div>
                </div>
                <ul>
                  <li class="new-users"></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- 1-1-blocks row end -->

        <div class="row">
            <div class="col-xl-8 col-lg-12">
                    
                    <div class="card">
                        <div class="card-block">
                            <h5>Score Vendedores</h5>

                            <div class="table-responsive">
                                <table class="table m-b-0 photo-table" id="tablaScoreVendedores">
                                    <thead>
                                    <tr class="text-uppercase">
                                        <th>Photo</th>
                                        <th>Vendedor</th>
                                        <th>Meta</th>
                                        <th>Ventas</th>
                                        
                                        <th>%</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tablaScoreVendedoresBody">
                                    <tr>
                                        <th>
                                            <img class="img-fluid rounded-circle" src="assets/images/avatar-2.png" alt="User">
                                        </th>
                                        <td>Juan Perez Zapata
                                            <p><i class="icofont icofont-clock-time"></i>Created 14.9.2016</p>
                                        </td>
                                        <td>$100.000</td>
                                        <td>$50.000</td>
                                        <td class="chart"> 
                                            <span class="pie" style="display: none;">180,180</span><svg class="peity" height="30" width="30">
        <path d="M 15.000000000000002 0 A 15 15 0 1 1 4.209902994920235 25.41987555688496 L 15 15" fill="#2196F3"></path>
        <path d="M 4.209902994920235 25.41987555688496 A 15 15 0 0 1 14.999999999999996 0 L 15 15" fill="#ccc"></path>
                                            </svg>
                                        </td>
                                        
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-sm-12 grid-item">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="basic-widget basic-widget-purple ">
                        <i class="icofont icofont-ui-user"></i>
                        <h5>Visitors</h5>
                        <div class="counter-txt">
                          <h4 class="counter-txt counter">10</h4>k
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="basic-widget basic-widget-green m-r-0">
                        <i class="icofont icofont-music"></i>
                        <h5>Volume</h5>
                        <div class="counter-txt">
                          <h4 class="counter">100</h4>%
                        </div>
                      </div>
                    </div>
                   
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="basic-widget basic-widget-orange">
                        <i class="icofont icofont-star"></i>
                        <h5>Rating</h5>
                        <h4 class="counter">578</h4>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="basic-widget basic-widget-pink m-r-0">
                        <i class="icofont icofont-trophy-alt"></i>
                        <h5>Achivement</h5>
                        <h4 class="counter">20</h4>
                      </div>
                    </div>
                    
                  </div>
                </div>
        </div>
        <!-- 2nd row start -->
        <div class="row" style="display: none;">
          <!-- 1 col start -->
          <div class="col-xl-4 col-sm-12 grid-item">
            <div class="row">
              <div class="col-sm-6">
                <div class="basic-widget basic-widget-purple ">
                  <i class="icofont icofont-ui-user"></i>
                  <h5>Visitors</h5>
                  <div class="counter-txt">
                    <h4 class="counter-txt counter">10</h4>k
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="basic-widget basic-widget-green m-r-0">
                  <i class="icofont icofont-music"></i>
                  <h5>Volume</h5>
                  <div class="counter-txt">
                    <h4 class="counter">100</h4>%
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="basic-widget basic-widget-orange">
                  <i class="icofont icofont-star"></i>
                  <h5>Rating</h5>
                  <h4 class="counter">578</h4>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="basic-widget basic-widget-pink m-r-0">
                  <i class="icofont icofont-trophy-alt"></i>
                  <h5>Achivement</h5>
                  <h4 class="counter">20</h4>
                </div>
              </div>
            </div>
          </div>
          <!-- 1 col end -->

          <!-- 2 col start -->
          <div class="col-xl-4">
            <div class="row">
              <div class="col-sm-12 grid-item">
                <div class="card">
                  <div class="card-block widget-activities">
                    <div class="row m-b-10">
                      <div class="col-sm-6 text-left">
                        <div class="counter-txt txt-primary">
                          <h6>User Activities</h6>
                          <span class="counter">210</span>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <i class="icon-link"></i>
                      </div>
                    </div>
                    <div class="widget-progress m-b-20">
                      <h6 class="text-left">Social Users</h6>
                      <div class="progress">
                        <div class="progress-bar1 bg-primary" style="width: 45%;">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <p>Page Visits</p>
                        <h6 class="counter">10.85</h6>
                      </div>
                      <div class="col-sm-6">
                        <p>New Visitors</p>
                        <h6 class="counter d-inline-block">45.83</h6>%
                      </div>
                    </div>
                  </div>
                  <div class="widget-income-footer p-10">
                    <p>This is standard panel footer </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- 1 col end -->
          <!-- 3 col start -->
          <div class="col-xl-4">
            <div class="card weather-card">
              <div class="weather-bg">
                <div>
                  <svg
                          version="1.1"
                          id="cloudDrizzleSun"
                          class="climacon climacon_cloudDrizzleSun"
                          viewBox="15 15 70 70">
                    <clipPath id="cloudFillClip">
                      <path d="M15,15v70h70V15H15z M59.943,61.639c-3.02,0-12.381,0-15.999,0c-6.626,0-11.998-5.371-11.998-11.998c0-6.627,5.372-11.999,11.998-11.999c5.691,0,10.434,3.974,11.665,9.29c1.252-0.81,2.733-1.291,4.334-1.291c4.418,0,8,3.582,8,8C67.943,58.057,64.361,61.639,59.943,61.639z"/>
                    </clipPath>
                    <clipPath id="sunCloudFillClip">
                      <path
                              d="M15,15v70h70V15H15z M57.945,49.641c-4.417,0-8-3.582-8-7.999c0-4.418,3.582-7.999,8-7.999s7.998,3.581,7.998,7.999C65.943,46.059,62.362,49.641,57.945,49.641z"/>
                    </clipPath>
                    <clipPath id="cloudSunFillClip">
                      <path
                              d="M15,15v70h20.947V63.481c-4.778-2.767-8-7.922-8-13.84c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,5.262-3.394,9.723-8.107,11.341V85H85V15H15z"/>
                    </clipPath>
                    <g class="climacon_iconWrap climacon_iconWrap-cloudDrizzleSun">
                      <g clip-path="url(#cloudSunFillClip)">
                        <g class="climacon_componentWrap climacon_componentWrap-sun climacon_componentWrap-sun_cloud">
                          <g class="climacon_componentWrap climacon_componentWrap_sunSpoke">
                            <path
                                    class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                                    d="M80.029,43.611h-3.998c-1.105,0-2-0.896-2-1.999s0.895-2,2-2h3.998c1.104,0,2,0.896,2,2S81.135,43.611,80.029,43.611z"/>
                            <path
                                    class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                                    d="M72.174,30.3c-0.781,0.781-2.049,0.781-2.828,0c-0.781-0.781-0.781-2.047,0-2.828l2.828-2.828c0.779-0.781,2.047-0.781,2.828,0c0.779,0.781,0.779,2.047,0,2.828L72.174,30.3z"/>
                            <path
                                    class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                                    d="M58.033,25.614c-1.105,0-2-0.896-2-2v-3.999c0-1.104,0.895-2,2-2c1.104,0,2,0.896,2,2v3.999C60.033,24.718,59.135,25.614,58.033,25.614z"/>
                            <path
                                    class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                                    d="M43.892,30.3l-2.827-2.828c-0.781-0.781-0.781-2.047,0-2.828c0.78-0.781,2.047-0.781,2.827,0l2.827,2.828c0.781,0.781,0.781,2.047,0,2.828C45.939,31.081,44.673,31.081,43.892,30.3z"/>
                            <path
                                    class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                                    d="M42.033,41.612c0,1.104-0.896,1.999-2,1.999h-4c-1.104,0-1.998-0.896-1.998-1.999s0.896-2,1.998-2h4C41.139,39.612,42.033,40.509,42.033,41.612z"/>
                            <path
                                    class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                                    d="M43.892,52.925c0.781-0.78,2.048-0.78,2.827,0c0.781,0.78,0.781,2.047,0,2.828l-2.827,2.827c-0.78,0.781-2.047,0.781-2.827,0c-0.781-0.78-0.781-2.047,0-2.827L43.892,52.925z"/>
                            <path
                                    class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                                    d="M58.033,57.61c1.104,0,2,0.895,2,1.999v4c0,1.104-0.896,2-2,2c-1.105,0-2-0.896-2-2v-4C56.033,58.505,56.928,57.61,58.033,57.61z"/>
                            <path
                                    class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                                    d="M72.174,52.925l2.828,2.828c0.779,0.78,0.779,2.047,0,2.827c-0.781,0.781-2.049,0.781-2.828,0l-2.828-2.827c-0.781-0.781-0.781-2.048,0-2.828C70.125,52.144,71.391,52.144,72.174,52.925z"/>
                          </g>
                          <g class="climacon_wrapperComponent climacon_wrapperComponent-sunBody" clip-path="url(#sunCloudFillClip)">
                            <circle
                                    class="climacon_component climacon_component-stroke climacon_component-stroke_sunBody"
                                    cx="58.033"
                                    cy="41.612"
                                    r="11.999"/>
                          </g>
                        </g>
                      </g>
                      <g class="climacon_wrapperComponent climacon_wrapperComponent-drizzle">
                        <path
                                class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-left"
                                d="M42.001,53.644c1.104,0,2,0.896,2,2v3.998c0,1.105-0.896,2-2,2c-1.105,0-2.001-0.895-2.001-2v-3.998C40,54.538,40.896,53.644,42.001,53.644z"/>
                        <path
                                class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-middle"
                                d="M49.999,53.644c1.104,0,2,0.896,2,2v4c0,1.104-0.896,2-2,2s-1.998-0.896-1.998-2v-4C48.001,54.54,48.896,53.644,49.999,53.644z"/>
                        <path
                                class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-right"
                                d="M57.999,53.644c1.104,0,2,0.896,2,2v3.998c0,1.105-0.896,2-2,2c-1.105,0-2-0.895-2-2v-3.998C55.999,54.538,56.894,53.644,57.999,53.644z"/>
                      </g>

                      <g class="climacon_wrapperComponent climacon_wrapperComponent-cloud" clip-path="url(#cloudFillClip)">
                        <path
                                class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
                                d="M63.999,64.944v-4.381c2.387-1.386,3.998-3.961,3.998-6.92c0-4.418-3.58-8-7.998-8c-1.603,0-3.084,0.481-4.334,1.291c-1.232-5.316-5.973-9.29-11.664-9.29c-6.628,0-11.999,5.372-11.999,12c0,3.549,1.55,6.729,3.998,8.926v4.914c-4.776-2.769-7.998-7.922-7.998-13.84c0-8.836,7.162-15.999,15.999-15.999c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.336-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12C71.997,58.864,68.655,63.296,63.999,64.944z"/>
                      </g>
                    </g>
                  </svg>
                  <h1>18°</h1>

                  <h6>Zurich, Switzerland</h6>
                </div>
              </div>
              <div class="card-block">
                <ul class="weather-detail text-center">
                  <li>
                    <h6>Mon</h6>
                    <svg
                            version="1.1"
                            id="cloudRain"
                            class="climacon climacon_cloudRain"
                            viewBox="15 15 70 70">
                      <clipPath id="cloudFillClip">
                        <path d="M15,15v70h70V15H15z M59.943,61.639c-3.02,0-12.381,0-15.999,0c-6.626,0-11.998-5.371-11.998-11.998c0-6.627,5.372-11.999,11.998-11.999c5.691,0,10.434,3.974,11.665,9.29c1.252-0.81,2.733-1.291,4.334-1.291c4.418,0,8,3.582,8,8C67.943,58.057,64.361,61.639,59.943,61.639z"/>
                      </clipPath>
                      <g class="climacon_iconWrap climacon_iconWrap-cloudRain">
                        <g class="climacon_wrapperComponent climacon_wrapperComponent-rain">
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- left"
                                  d="M41.946,53.641c1.104,0,1.999,0.896,1.999,2v15.998c0,1.105-0.895,2-1.999,2s-2-0.895-2-2V55.641C39.946,54.537,40.842,53.641,41.946,53.641z"/>
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- middle"
                                  d="M49.945,57.641c1.104,0,2,0.896,2,2v15.998c0,1.104-0.896,2-2,2s-2-0.896-2-2V59.641C47.945,58.535,48.841,57.641,49.945,57.641z"/>
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- right"
                                  d="M57.943,53.641c1.104,0,2,0.896,2,2v15.998c0,1.105-0.896,2-2,2c-1.104,0-2-0.895-2-2V55.641C55.943,54.537,56.84,53.641,57.943,53.641z"/>
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- left"
                                  d="M41.946,53.641c1.104,0,1.999,0.896,1.999,2v15.998c0,1.105-0.895,2-1.999,2s-2-0.895-2-2V55.641C39.946,54.537,40.842,53.641,41.946,53.641z"/>
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- middle"
                                  d="M49.945,57.641c1.104,0,2,0.896,2,2v15.998c0,1.104-0.896,2-2,2s-2-0.896-2-2V59.641C47.945,58.535,48.841,57.641,49.945,57.641z"/>
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- right"
                                  d="M57.943,53.641c1.104,0,2,0.896,2,2v15.998c0,1.105-0.896,2-2,2c-1.104,0-2-0.895-2-2V55.641C55.943,54.537,56.84,53.641,57.943,53.641z"/>
                        </g>
                        <g class="climacon_wrapperComponent climacon_wrapperComponent_cloud" clip-path="url(#cloudFillClip)">
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
                                  d="M63.943,64.941v-4.381c2.389-1.384,4-3.961,4-6.92c0-4.417-3.582-8-8-8c-1.601,0-3.082,0.48-4.334,1.291c-1.23-5.317-5.973-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.998c0,3.549,1.551,6.728,4,8.924v4.916c-4.777-2.768-8-7.922-8-13.84c0-8.835,7.163-15.997,15.998-15.997c6.004,0,11.229,3.311,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.372,11.998,12C71.941,58.863,68.602,63.293,63.943,64.941z"/>
                        </g>
                      </g>
                    </svg>
                  </li>
                  <li>
                    <h6>Tue</h6>
                    <svg
                            version="1.1"
                            id="cloud"
                            class="climacon climacon_cloud"
                            viewBox="15 15 70 70">
                      <clipPath id="cloudFillClip">
                        <path d="M15,15v70h70V15H15z M59.943,61.639c-3.02,0-12.381,0-15.999,0c-6.626,0-11.998-5.371-11.998-11.998c0-6.627,5.372-11.999,11.998-11.999c5.691,0,10.434,3.974,11.665,9.29c1.252-0.81,2.733-1.291,4.334-1.291c4.418,0,8,3.582,8,8C67.943,58.057,64.361,61.639,59.943,61.639z"/>
                      </clipPath>
                      <g class="climacon_iconWrap climacon_iconWrap-cloud">
                        <g class="climacon_componentWrap climacon_componentWrap_cloud" clip-path="url(#cloudFillClip)">
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
                                  d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
                        </g>
                      </g>
                    </svg>
                  </li>
                  <li>
                    <h6>Wed</h6>
                    <svg version="1.1"
                         id="sunFill"
                         class="climacon climacon_sunFill"
                         viewBox="15 15 70 70">
                      <g class="climacon_iconWrap climacon_iconWrap-sunFill">
                        <g class="climacon_componentWrap climacon_componentWrap-sun">
                          <g class="climacon_componentWrap climacon_componentWrap-sunSpoke">
                            <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-east"
                                  d="M72.03,51.999h-3.998c-1.105,0-2-0.896-2-1.999s0.895-2,2-2h3.998c1.104,0,2,0.896,2,2S73.136,51.999,72.03,51.999z"/>
                            <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-northEast"
                                  d="M64.175,38.688c-0.781,0.781-2.049,0.781-2.828,0c-0.781-0.781-0.781-2.047,0-2.828l2.828-2.828c0.779-0.781,2.047-0.781,2.828,0c0.779,0.781,0.779,2.047,0,2.828L64.175,38.688z"/>
                            <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north"
                                  d="M50.034,34.002c-1.105,0-2-0.896-2-2v-3.999c0-1.104,0.895-2,2-2c1.104,0,2,0.896,2,2v3.999C52.034,33.106,51.136,34.002,50.034,34.002z"/>
                            <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-northWest"
                                  d="M35.893,38.688l-2.827-2.828c-0.781-0.781-0.781-2.047,0-2.828c0.78-0.781,2.047-0.781,2.827,0l2.827,2.828c0.781,0.781,0.781,2.047,0,2.828C37.94,39.469,36.674,39.469,35.893,38.688z"/>
                            <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-west"
                                  d="M34.034,50c0,1.104-0.896,1.999-2,1.999h-4c-1.104,0-1.998-0.896-1.998-1.999s0.896-2,1.998-2h4C33.14,48,34.034,48.896,34.034,50z"/>
                            <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-southWest"
                                  d="M35.893,61.312c0.781-0.78,2.048-0.78,2.827,0c0.781,0.78,0.781,2.047,0,2.828l-2.827,2.827c-0.78,0.781-2.047,0.781-2.827,0c-0.781-0.78-0.781-2.047,0-2.827L35.893,61.312z"/>
                            <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-south"
                                  d="M50.034,65.998c1.104,0,2,0.895,2,1.999v4c0,1.104-0.896,2-2,2c-1.105,0-2-0.896-2-2v-4C48.034,66.893,48.929,65.998,50.034,65.998z"/>
                            <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-southEast"
                                  d="M64.175,61.312l2.828,2.828c0.779,0.78,0.779,2.047,0,2.827c-0.781,0.781-2.049,0.781-2.828,0l-2.828-2.827c-0.781-0.781-0.781-2.048,0-2.828C62.126,60.531,63.392,60.531,64.175,61.312z"/>
                          </g>
                          <g class="climacon_componentWrap climacon_componentWrap_sunBody">
                            <circle class="climacon_component climacon_component-stroke climacon_component-stroke_sunBody"
                                    cx="50.034"
                                    cy="50"
                                    r="11.999"/>
                            <circle class="climacon_component climacon_component-fill climacon_component-fill_sunBody"
                                    fill="#FFFFFF"
                                    cx="50.034"
                                    cy="50"
                                    r="7.999"/>
                          </g>
                        </g>
                      </g>
                    </svg>
                  </li>
                  <li>
                    <h6>Thu</h6>
                    <svg
                            version="1.1"
                            id="cloudDrizzleMoonFillAlt"
                            class="climacon climacon_cloudDrizzleMoonFillAlt"
                            viewBox="15 15 70 70">
                      <g class="climacon_iconWrap climacon_iconWrap-cloudDrizzleMoonFillAlt">
                        <g class="climacon_wrapperComponent climacon_wrapperComponent-moon climacon_componentWrap-moon_cloud">
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_sunBody"
                                  d="M61.023,50.641c-6.627,0-11.999-5.372-11.999-11.998c0-6.627,5.372-11.999,11.999-11.999c0.755,0,1.491,0.078,2.207,0.212c-0.132,0.576-0.208,1.173-0.208,1.788c0,4.418,3.582,7.999,8,7.999c0.614,0,1.212-0.076,1.788-0.208c0.133,0.717,0.211,1.452,0.211,2.208C73.021,45.269,67.649,50.641,61.023,50.641z"/>
                          <path
                                  class="climacon_component climacon_component-fill climacon_component-fill_moon"
                                  fill="#FFFFFF"
                                  d="M59.235,30.851c-3.556,0.813-6.211,3.989-6.211,7.792c0,4.417,3.581,7.999,7.999,7.999c3.802,0,6.979-2.655,7.791-6.211C63.961,39.527,60.139,35.705,59.235,30.851z"/>
                        </g>
                        <g class="climacon_wrapperComponent climacon_wrapperComponent-drizzle">
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-left"
                                  id="Drizzle-Left_1_"
                                  d="M56.969,57.672l-2.121,2.121c-1.172,1.172-1.172,3.072,0,4.242c1.17,1.172,3.07,1.172,4.24,0c1.172-1.17,1.172-3.07,0-4.242L56.969,57.672z"/>
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-middle"
                                  d="M50.088,57.672l-2.119,2.121c-1.174,1.172-1.174,3.07,0,4.242c1.17,1.172,3.068,1.172,4.24,0s1.172-3.07,0-4.242L50.088,57.672z"/>
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-right"
                                  d="M43.033,57.672l-2.121,2.121c-1.172,1.172-1.172,3.07,0,4.242s3.07,1.172,4.244,0c1.172-1.172,1.172-3.07,0-4.242L43.033,57.672z"/>
                        </g>
                        <g class="climacon_componentWrap climacon_componentWrap_cloud">
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
                                  d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
                          <path
                                  class="climacon_component climacon_component-fill climacon_component-fill_cloud"
                                  fill="#FFFFFF"
                                  d="M59.943,61.639c4.418,0,8-3.582,8-7.998c0-4.417-3.582-8-8-8c-1.601,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.973-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.999c0,6.626,5.372,11.998,11.998,11.998C47.562,61.639,56.924,61.639,59.943,61.639z"/>
                        </g>
                      </g>
                    </svg>
                  </li>
                  <li>
                    <h6>Fri</h6>
                    <svg
                            version="1.1"
                            id="cloudSnowAltFill"
                            class="climacon climacon_cloudSnowAltFill"
                            viewBox="15 15 70 70">
                      <g class="climacon_iconWrap climacon_iconWrap-cloudSnowAltFill">
                        <g class="climacon_wrapperComponent climacon_wrapperComponent-snowAlt">
                          <g class="climacon_component climacon_component climacon_component-snowAlt">
                            <path
                                    class="climacon_component climacon_component-stroke climacon_component-stroke_snowAlt"
                                    d="M43.072,59.641c0.553-0.957,1.775-1.283,2.732-0.731L48,60.176v-2.535c0-1.104,0.896-2,2-2c1.104,0,2,0.896,2,2v2.535l2.195-1.268c0.957-0.551,2.18-0.225,2.73,0.732c0.553,0.957,0.225,2.18-0.73,2.731l-2.196,1.269l2.196,1.268c0.955,0.553,1.283,1.775,0.73,2.732c-0.552,0.954-1.773,1.282-2.73,0.729L52,67.104v2.535c0,1.105-0.896,2-2,2c-1.104,0-2-0.895-2-2v-2.535l-2.195,1.269c-0.957,0.553-2.18,0.226-2.732-0.729c-0.552-0.957-0.225-2.181,0.732-2.732L46,63.641l-2.195-1.268C42.848,61.82,42.521,60.598,43.072,59.641z"/>
                            <circle
                                    class="climacon_component climacon_component-fill climacon_component-fill_snowAlt"
                                    fill="#FFFFFF"
                                    cx="50"
                                    cy="63.641"
                                    r="2"/>
                          </g>
                        </g>
                        <g class="climacon_componentWrap climacon_componentWrap_cloud">
                          <path
                                  class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
                                  d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
                          <path
                                  class="climacon_component climacon_component-fill climacon_component-fill_cloud"
                                  fill="#FFFFFF"
                                  d="M59.943,61.639c4.418,0,8-3.582,8-7.998c0-4.417-3.582-8-8-8c-1.601,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.973-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.999c0,6.626,5.372,11.998,11.998,11.998C47.562,61.639,56.924,61.639,59.943,61.639z"/>
                        </g>
                      </g>
                    </svg>
                  </li>
                </ul>
              </div>
              <div class="widget-income-footer p-10">
                    <p>This is standard panel footer Weather</p>
                  </div>
                </div>
          </div>
          <!-- 1 col end -->

          </div>
        </div>
        <!-- 2nd row end -->

	@php
		$local = Session::get('local');
	@endphp

	@if ($local)
		@php
			print_r("<pre>");
			print_r($local);
			print_r("</pre>");
		@endphp
	@endif

@endsection

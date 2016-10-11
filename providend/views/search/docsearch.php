<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\ListView;
use frontend\models\GeoLoc;
use frontend\models\GeolocSearch;
use dosamigos\leaflet\layers\LayerGroup;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\types\Icon;
use dosamigos\leaflet\plugins\geocoder\ServiceNominatim;
use dosamigos\leaflet\plugins\geocoder\GeoCoder;
use dosamigos\leaflet\plugins\makimarker\MakiMarker;
use Ivory\HttpAdapter\CurlHttpAdapter;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HealthSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Html::encode($zipcode);

$this->params['breadcrumbs'][] = 'Physicans near '.$this->title;
?>

<div class="search-index">

    <h1><?= Html::encode('HealthCare Providers near '.$this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    //?=ListView::widget([
    //    'dataProvider' => $dataProvider,
    //
    //    'pagination'=>[pageSize'=>20,
    //    ]
    //    ]);
    //?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'first_name',
            'mid_name',
            'last_name',
            'address_1',
            //'address_2',
            'city',
            'state',
            'zip',
            //'med_id',
            //'npi',
            //'ind_pac_id',
            //'ind_enrl_id',
            // 'suffix',
            // 'gender',
            // 'credential',
            // 'med_school',
            // 'grad_yr',
            // 'pri_spec',
            // 'sec_spec1',
            // 'sec_spec2',
            // 'sec_spec3',
            // 'sec_spec4',
            // 'sec_spec_all',
            // 'org_legal_name',
            // 'org_dba_name',
            // 'grp_prac_pac_id',
            // 'num_grp_prac_mem',
            // 'marker_add_2',
            // 'hosp_aff_ccn_1',
            // 'hosp_aff_lbn_1',
            // 'hosp_aff_ccn_2',
            // 'hosp_aff_lbn_2',
            // 'hosp_aff_ccn_3',
            // 'hosp_aff_lbn_3',
            // 'hosp_aff_ccn_4',
            // 'hosp_aff_lbn_4',
            // 'hosp_aff_ccn_5',
            // 'hosp_aff_lbn_5',
            // 'medicare',
            // 'erx',
            // 'pqrs',
            // 'ehr',
            // 'pqrs_cert',
            // 'mil_hearts',

            ['class' => 'kartik\grid\ActionColumn',
            'headerOptions' => ['style'=>'width: 20px;'],
            'template' => '{view} {prices}',
            //'viewOptions'=>['label'=>'<i class="glyphicon glyphicon-eye-open"> Details</i>'],
            'buttons' => [
                'view' => function ($url, $model) use ($zipcode) {
                    $url .= '&zipcode=' . $zipcode; //This is where I want to append the $lastAddress variable.
                    return Html::a('<i class="glyphicon glyphicon-eye-open" style="color:blue"> Details</i><br><br>', $url);
                    },
                'prices' => function ($url, $model) use ($zipcode) {
                    $url .= '&zipcode=' . $zipcode; //This is where I want to append the $lastAddress variable.
                    return Html::a('<i class="glyphicon glyphicon-usd" style="color:green"> Prices</i>', $url);
                    },
                ],
            ],    
        ],    
    ]); ?>

    <div>
    <?php

    // Map
    $curl     = new \Ivory\HttpAdapter\CurlHttpAdapter();
    $geocoder = new \Geocoder\Provider\GoogleMaps($curl);

    $i = 1;
    $cnt = 0;
    foreach ($dataProvider->models as $model) {
        $docloc[$i] = $model->address_1.','.$model->city.','.$model->state;
        #echo $docloc[$i].'<BR>';
        
        $model_data = GeoLoc::find()
                            ->where(['address' =>$docloc[$i]])
                            ->one();
        
        if ($model_data) {
        //    echo $model_data->address;
        }

        $i +=1;
        $cnt +=1;

        if ($cnt >= 10) {
            return;
        }
        
    }

    $docloc[0] = $zipcode;
    #$GeoLocData[0] = $GeoLocModel->find(['GeoLoc'=>['address'=>$docloc[0]]])->one();
    for ($j = 0; $j < count($docloc); $j++)
    {
        $doclatlon[$j] = $geocoder->geocode($docloc[$j])->first();   
        $dumper = new \Geocoder\Dumper\GeoJson();
        $jsondata = $dumper->dump($doclatlon[$j]);
        $decoded = json_decode($jsondata);
        $longlat = $decoded->{'geometry'}->{'coordinates'};
        //echo $longlat[0].' ';
        //echo $longlat[1].'<BR>';
        $markers[$j] = new LatLng(['lat' => $longlat[1], 'lng' => $longlat[0]]);
    }

    // lets use nominating service
    $nominatim = new ServiceNominatim();

    // create geocoder plugin and attach the service
    $geoCoderPlugin = new GeoCoder([
        'service' => $nominatim,
        'clientOptions' => [
            'showMarker' => true,
            'showResultIcons' => true,
            'collapsed' => true,
            'position' => 'topright',
            'placeholder' => "Find...",
        ]
    ]);

    // configure the tile layer
    $tileLayer = new TileLayer([
        'urlTemplate' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg',
        'clientOptions' => [
            'attribution' => 'Tiles Courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> ' .
                '<img src="http://developer.mapquest.com/content/osm/mq_logo.png">, ' .
                'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' .
                '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
            'subdomains' => '1234'
        ]
    ]);

    $center = $markers[0];

    // initialize our leafLet component
    $leafLet = new LeafLet([
        'name' => 'geoMap',
        //'tileLayer' => $tileLayer,
        'center' => $center,
        'zoom' => 10,
        'clientEvents' => [
            // I added an event to ease the collection of new position
            'geocoder_showresult' => 'function(e){
                geoMarker.setLatLng(e.Result.center);
            }'
        ]
    ]);

    // Initialize plugin
    $makimarkers = new MakiMarker(['name' => 'makimarker']);

    // install
    $leafLet->installPlugin($makimarkers);

    // generate icon through its icon
    $marker = new Marker([
        'latLng' => $center,
        'icon' => $leafLet->plugins->makimarker->make("building",['color' => "#b0b", 'size' => "l"]),
        'popupContent' => $docloc[0]
        ]);
   
    // add the marker
    $leafLet->addLayer($marker);

    for($m = 1; $m < count($markers); $m++)
    {
        $color = dechex(rand(0x000000, 0xFFFFFF));
    
        // add a marker to center
        $docmarker = new Marker([
            'name' => 'geoMarker',
            'latLng' => $markers[$m],
            'icon' => $leafLet->plugins->makimarker->make("hospital",['color' => $color, 'size' => "2"]),
            'popupContent' => $docloc[$m]
        ]);

        //print $docloc[$m]."<BR>";
        //print $m;

        $leafLet->addLayer($docmarker);
    }

    $leafLet->addLayer($tileLayer);

    // run the widget (you can also use dosamigos\leaflet\widgets\Map::widget([...]))
    echo $leafLet->widget();

    ?>
    <BR></div>

<p>
    <?= Html::a('Search Again', ['index'], ['class' => 'btn btn-primary']) ?>
</p>

</div>



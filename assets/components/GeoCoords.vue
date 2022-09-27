<template>
    <div>
        <yandex-map zoom="14" :options="mapOptions" :coords="mapCoords" :settings="mapSettings" @click="handleMapClick">
            <ymap-marker v-if="pointCoords" marker-id="1" :coords="pointCoords" :icon="markerIcon" @click="handleMarkerClick" />
        </yandex-map>
        <input type="hidden" v-model="valueToString" :name="name"></input>
    </div>
</template>

<script>

import { yandexMap, ymapMarker } from 'vue-yandex-maps';

const defaultMapCoords = [59.938951, 30.315635];

export default {
    name: "GeoCoords",
    props: {
        name,
        value: String,
    },
    components: {yandexMap, ymapMarker},
    data: () => {
        return {
            mapCoords: defaultMapCoords,
            pointCoords: null,
            markerIcon: {
                glyph: 'islands#redCircleDotIcon',
                id: 1,
            },
            mapSettings: {
                apiKey: '',
                lang: 'ru_RU',
                coordorder: 'latlong',
                version: '2.1',
            },
            mapOptions: {
                yandexMapDisablePoiInteractivity: true
            }
        };
    },
    methods: {
        handleMapClick(clickEvent) {
            this.pointCoords = clickEvent.get('coords');
        },
        handleMarkerClick() {
            this.pointCoords = null;
        }
    },
    mounted() {
        let val = this.value ? JSON.parse(this.value) : null;
        this.pointCoords = val;
        if (val && val.length === 2) {
            this.mapCoords = val;
        }
    },
     computed: {
        valueToString() {
            return JSON.stringify(this.pointCoords);
        }
    }
}
</script>

<style scoped>
    .ymap-container {
        height: 350px;
    }
</style>

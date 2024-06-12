@php /** @var GianTiaga\MoonshineCoordinates\Fields\Coordinates $element */ @endphp
<div
    x-data="{
        map: null,
        marker: null,
        center: @js($element->center()),
        zoom: @js($element->zoom()),
        value: @js($element->value()),
        latitude: null,
        longitude: null,
        searched: [],
        timer: null,
        isShowResults: false,
        search(event) {
            if (event.target.value.length < 3) {
                return;
            }

            fetch('https://nominatim.openstreetmap.org/search?format=json&limit=10&q=' + event.target.value)
                    .then((r) => r.json())
                    .then((r) => {
                        this.searched = r;
                        this.isShowResults = true;
                    })
                    .catch(() => console.error(arguments));
        },
        updateCoords() {
            this.latitude = this.marker.getLatLng().lat;
            this.longitude = this.marker.getLatLng().lng;
        },
        setCoordinatesToMarker(lat, lng) {
            this.marker.setLatLng([lat, lng]);
            this.updateCoords();
            this.map.panTo([lat, lng]);
            this.map.setZoom(14);
            this.isShowResults = false;
        },
    }"
    x-init="
        if (value && value.latitude !== undefined && value.longitude !== undefined) {
            latitude = value.latitude;
            longitude = value.longitude;
        }

        $nextTick(function () {
            const base64icon = 'data:image/png;base64,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';

            const base64shadow = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACkAAAApCAYAAACoYAD2AAAC5ElEQVRYw+2YW4/TMBCF45S0S1luXZCABy5CgLQgwf//S4BYBLTdJLax0fFqmB07nnQfEGqkIydpVH85M+NLjPe++dcPc4Q8Qh4hj5D/AaQJx6H/4TMwB0PeBNwU7EGQAmAtsNfAzoZkgIa0ZgLMa4Aj6CxIAsjhjOCoL5z7Glg1JAOkaicgvQBXuncwJAWjksLtBTWZe04CnYRktUGdilALppZBOgHGZcBzL6OClABvMSVIzyBjazOgrvACf1ydC5mguqAVg6RhdkSWQFj2uxfaq/BrIZOLEWgZdALIDvcMcZLD8ZbLC9de4yR1sYMi4G20S4Q/PWeJYxTOZn5zJXANZHIxAd4JWhPIloTJZhzMQduM89WQ3MUVAE/RnhAXpTycqys3NZALOBbB7kFrgLesQl2h45Fcj8L1tTSohUwuxhy8H/Qg6K7gIs+3kkaigQCOcyEXCHN07wyQazhrmIulvKMQAwMcmLNqyCVyMAI+BuxSMeTk3OPikLY2J1uE+VHQk6ANrhds+tNARqBeaGc72cK550FP4WhXmFmcMGhTwAR1ifOe3EvPqIegFmF+C8gVy0OfAaWQPMR7gF1OQKqGoBjq90HPMP01BUjPOqGFksC4emE48tWQAH0YmvOgF3DST6xieJgHAWxPAHMuNhrImIdvoNOKNWIOcE+UXE0pYAnkX6uhWsgVXDxHdTfCmrEEmMB2zMFimLVOtiiajxiGWrbU52EeCdyOwPEQD8LqyPH9Ti2kgYMf4OhSKB7qYILbBv3CuVTJ11Y80oaseiMWOONc/Y7kJYe0xL2f0BaiFTxknHO5HaMGMublKwxFGzYdWsBF174H/QDknhTHmHHN39iWFnkZx8lPyM8WHfYELmlLKtgWNmFNzQcC1b47gJ4hL19i7o65dhH0Negbca8vONZoP7doIeOC9zXm8RjuL0Gf4d4OYaU5ljo3GYiqzrWQHfJxA6ALhDpVKv9qYeZA8eM3EhfPSCmpuD0AAAAASUVORK5CYII=';

            const markerIcon = L.icon({
                iconUrl: base64icon,
                iconAnchor: [12, 41],
                iconSize: [25, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41],
                shadowUrl: base64shadow
            });

            const hasValue = latitude && longitude;

            map = L.map($refs.map, {
                center: hasValue
                    ? [latitude, longitude]
                    : [center.latitude, center.longitude],
                zoom: hasValue ? 14 : zoom,
                scrollWheelZoom: false,
            });

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a> contributors'
            }).addTo(map);

            marker = L.marker([center.latitude, center.longitude], {
                icon: markerIcon,
                draggable: true,
                autoPan: true,
                autoPanPadding: L.point(100, 100)
            }).addTo(map);

            if (hasValue) {
                marker.setLatLng([latitude, longitude]);
            }

            marker.on('dragend', () => {
                updateCoords();
            });

            map.on('click', (e) => {
                marker.setLatLng(e.latlng);
                updateCoords();
                map.panTo(e.latlng);
            });
        });
    "
>
    <div class="relative">
        <div>
            <x-moonshine::form.input
                placeholder="Поиск"
                x-on:input.debounce.250ms="search($event)"
            />
        </div>

        <x-moonshine::box
            x-show="isShowResults"
            @click.outside="isShowResults = false"
            class="absolute"
            style="z-index: 9000"
        >
            <template x-for="item in searched">
                <div>
                    <button
                        x-text="item.display_name"
                        class="cursor-pointer"
                        style="text-align: left"
                        type="button"
                        @click="setCoordinatesToMarker(item.lat, item.lon)"
                    ></button>
                    <x-moonshine::divider />
                </div>
            </template>
        </x-moonshine::box>
    </div>

    <div x-ref="map"
         style="width: 100%; height: 500px;"
         class="mt-2 rounded-md"
    ></div>

    <div class="flex gap-2 mt-2">
        <x-moonshine::form.input
            type="text"
            placeholder="Широта"
            x-model="latitude"
            :attributes="new \Illuminate\View\ComponentAttributeBag([
                'required' => $element->isRequired(),
            ])"
        />

        <x-moonshine::form.input
            type="text"
            placeholder="Долгота"
            x-model="longitude"
            :attributes="new \Illuminate\View\ComponentAttributeBag([
                'required' => $element->isRequired(),
            ])"
        />

        <x-moonshine::form.input
            type="hidden"
            x-bind:value="JSON.stringify({latitude, longitude})"
            name="{{ $element->column() }}"
        />
    </div>
</div>

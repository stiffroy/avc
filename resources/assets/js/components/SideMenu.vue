<template>
    <va-slider :slideMenuItems="slideMenuItems"></va-slider>
</template>

<script>
    import VASlider from './overrides/Slider.vue';
    import slideMenuItems from './data/slideMenuItems';

    export default {
        data: () => {
            return {
                slideMenuItems: slideMenuItems,
            }
        },
        components: {
            'va-slider': VASlider,
        }
    }
</script>

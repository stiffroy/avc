<template>
    <aside id="slider" class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel" v-if="$store.state.isLoggedIn">
                <div class="pull-left image">
                    <i class="fa fa-3x fa-user-circle"></i>
                </div>
                <div class="pull-left info">
                    <p>{{ $store.state.authUser.name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <ul data-widget="tree" class="sidebar-menu" v-show="$store.state.isLoggedIn">
                <va-slide-item
                        v-for="(item,index) in slideMenuItems"
                        :data="item"
                        :key="index"
                        :type="item.type"
                        :isHeader="item.isHeader"
                        :icon="item.icon"
                        :name="item.name"
                        :badge="item.badge"
                        :items="item.items"
                        :router="item.router"
                        :link="item.link"
                >
                </va-slide-item>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
    import VASlideItem from 'vue2-admin-lte/src/components/VASlideItem';

    export default {
        name: 'va-slider',
        props: {
            slideMenuItems: {
                type: Array,
                default: []
            }
        },
        components: {
            'va-slide-item': VASlideItem
        },
        data: () => {
            return {
                user: JSON.parse(localStorage.getItem('user')),
            }
        }
    }
</script>

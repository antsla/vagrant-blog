@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs))

@section('content')
    <div id="appSetting">
        <table class="table table-vue">
            <tr>
                <th class="settings-actions">
                    <span
                            v-bind:class="{ 'glyphicon-arrow-down' : sorting.name == true, 'glyphicon-arrow-up' : sorting.name == false, 'glyphicon-minus' : sorting.name == '-' }"
                            v-on:click="nameSort()"
                            class="glyphicon">
                    </span>
                    {{ Lang::get('admin/settings.th_name') }}
                </th>
                <th class="settings-actions">
                    <span
                            v-bind:class="{ 'glyphicon-arrow-down' : sorting.value == true, 'glyphicon-arrow-up' : sorting.value == false, 'glyphicon-minus' : sorting.value == '-' }"
                            v-on:click="valueSort()"
                            class="glyphicon">
                    </span>
                    {{ Lang::get('admin/settings.th_value') }}
                </th>
                <th>
                    {{ Lang::get('admin/settings.th_delete') }}
                </th>
            </tr>

            <template v-for="(setting, index) in settings">
                <tr>
                    <td>
                        <div v-show="setting != editSet" v-on:dblclick="[ editSet = setting ]">
                            @{{ setting.name }}
                        </div>
                        <input
                                class="form-control"
                                v-on:keyup.enter="updSetting(setting.id, editSet.name, editSet.value)"
                                v-model="editSet.name"
                                v-show="setting == editSet"
                                type="text"/>
                    </td>
                    <td>
                        <div v-show="setting != editSet" v-on:dblclick="[ editSet = setting ]">
                            @{{ setting.value }}
                        </div>
                        <input
                                class="form-control"
                                v-on:keyup.enter="updSetting(setting.id, editSet.name, editSet.value)"
                                v-model="editSet.value"
                                v-show="setting == editSet"
                                type="text" />
                    </td>
                    <td class="settings-actions">
                        <span
                                class="glyphicon glyphicon-remove"
                                v-on:click="delSetting(setting.id, index)">
                        </span>
                    </td>
                </tr>
            </template>
        </table>

        <form v-on:submit.prevent="addSetting">
            {!! Form::token() !!}
            <table class="table">
                <tr>
                    <td>
                        <input v-model="newSet.name" class="form-control" type="text" placeholder="{{ Lang::get('admin/settings.ph_name') }}" />
                    </td>
                    <td>
                        <input v-model="newSet.value" class="form-control" type="text" placeholder="{{ Lang::get('admin/settings.ph_value') }}" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" class="btn btn-info" value="{{ Lang::get('admin/settings.btn_add') }}"/>
                    </td>
                </tr>
            </table>
        </form>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/admin/vue.settings.js') }}"></script>
@endsection
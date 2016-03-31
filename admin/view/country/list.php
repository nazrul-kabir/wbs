<?php
include '../../../config/config.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include basePath('admin/header_script.php'); ?>
    </head>
    <body class="skin-blue">
        <div class="wrapper">
            <?php include basePath('admin/header.php'); ?>
            <aside class="main-sidebar">
                <?php include basePath('admin/site_menu.php'); ?>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>Country List</h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-laptop"></i>&nbsp;General Settings</li>
                        <li class="active">Country List</li>
                    </ol>
                </section>
                <section class="content">
                    <?php include basePath('admin/message.php'); ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">

                                <div id="grid"></div>


                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        var dataSource = new kendo.data.DataSource({
                                            pageSize: 10,
                                            transport: {
                                                read: {
                                                    url: baseUrl + "admin/controller/country/list.php",
                                                    type: "GET"
                                                },
                                                update: {
                                                    url: baseUrl + "admin/controller/country/list.php",
                                                    type: "POST",
                                                    complete: function (e) {
                                                        $("#grid").data("kendoGrid").dataSource.read();
                                                    }
                                                },
                                                destroy: {
                                                    url: baseUrl + "admin/controller/country/list.php",
                                                    type: "DELETE"
                                                },
                                                create: {
                                                    url: baseUrl + "admin/controller/country/list.php",
                                                    type: "PUT",
                                                    complete: function (e) {
                                                        $("#grid").data("kendoGrid").dataSource.read();
                                                    }
                                                }
                                            },
                                            autoSync: false,
                                            schema: {
                                                data: "data",
                                                total: "data.length",
                                                model: {
                                                    id: "country_id",
                                                    fields: {
                                                        country_id: {editable: false, nullable: true},
                                                        country_name: {type: "string"}
                                                    }
                                                }
                                            }
                                        });
                                        $("#grid").kendoGrid({
                                            dataSource: dataSource,
                                            filterable: true,
                                            pageable: {
                                                refresh: true,
                                                input: true,
                                                numeric: false,
                                                pageSizes: true,
                                                pageSizes: [10, 20, 50, 100, 200],
                                            },
                                            sortable: true,
                                            groupable: true,
                                            toolbar: [
                                                {name: "create", text: "Add Country"}
                                            ],
                                            columns: [
                                                {field: "country_name", title: "Country Name", width: "150px"},
                                                {command: ["edit", "destroy"], title: "Action", width: "180px"}],
                                            editable: "inline"
                                        });

                                    });

                                </script>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include basePath('admin/footer.php'); ?>
        </div>
        <script type="text/javascript">
            $("#countryActive").addClass("active");
            $("#countryActive").parent().parent().addClass("treeview active");
            $("#countryActive").parent().addClass("in");
        </script>
        <?php include basePath('admin/footer_script.php'); ?>
    </body>
</html>
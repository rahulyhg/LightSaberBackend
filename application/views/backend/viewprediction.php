<div class="row" style="padding:1% 0">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right" href="<?php echo site_url("site/createprediction"); ?>"><i class="icon-plus"></i>Create </a> &nbsp;
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                prediction Details
            </header>
            <div class="drawchintantable">
                <?php $this->chintantable->createsearch("prediction List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th data-field="id">ID</th>
                            <th data-field="predictiongroup">Prediction Group</th>
                            <th data-field="name">Name</th>
                            <th data-field="status">Status</th>
                            <th data-field="predictionteam">Winner</th>
                            <th data-field="endtime">End Time</th>
                            <th data-field="order">Order</th>
                            <th data-field="Action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <?php $this->chintantable->createpagination();?>
            </div>
        </section>
        <script>
            function drawtable(resultrow) {
                if(resultrow.status==0)
                {
                    resultrow.status="Disable";
                }
                else if(resultrow.status==1)
                {
                    resultrow.status="Enable";
                }
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.predictiongroup + "</td><td>" + resultrow.name + "</td><td>" + resultrow.status + "</td><td>" + resultrow.predictionteam + "</td><td>" + resultrow.endtime + "</td><td>" + resultrow.order + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editprediction?id=');?>" + resultrow.id + "'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deleteprediction?id='); ?>" + resultrow.id + "'><i class='icon-trash '></i></a></td></tr>";
            }
            generatejquery("<?php echo $base_url;?>");
        </script>
    </div>
</div>

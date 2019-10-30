<?php

    if (!empty($values)) {

        foreach ($values as $row) { ?>

            <div class="panel panel-default">

                <div class="panel-heading">

                    <h4 class="panel-title">

                        <a data-toggle="collapse" data-parent="#leftMenu"

                           href="#ajaxCollapse_<?php echo $row['id']; ?>">

                            <?php echo $row['question']; ?></a>

                    </h4>

                </div>

                <div id="ajaxCollapse_<?php echo $row['id']; ?>"

                     class="panel-collapse collapse <?= ($i == 0) ? 'in' : ''; ?>">

                    <div class="panel-body">

                        <?php echo $row['answer']; ?>

                    </div>

                </div>

            </div>

            <?php

            $i++;

        }

    } ?>
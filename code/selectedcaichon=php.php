 <div class="col-md-3">
                <label>Phòng</label>
                <select class="form-control chosen-select" name="phong" id="phong">
                    <option value="0">---</option>
                    <?php
                    $ok = select_list($conn, "select * from tdwi8up");

                    foreach ($ok as $value1) {
                        $select='';
                        if($_POST['phong'] == $value1["Tdwi8up_id"]) $select='selected';
                        ?>
                        <option value="<?= $value1["Tdwi8up_id"] ?>" <?= $select ?>><?= $value1["Tdwi8up_oZnNbt"] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
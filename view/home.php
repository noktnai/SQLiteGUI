<?php
require_once("controller/home.php");
?>
<main class="m-6 __mx-md-ex">
    <!-- 通知 -->
    <?php if (isset($_SESSION["flash"])) : ?>
        <div class="flash flash-success mb-4"><svg class="octicon octicon-shield-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                <path fill-rule="evenodd' clip-rule=" evenodd" d="M8.53336 0.133063C8.18645 0.0220524 7.81355 0.0220518 7.46664 0.133062L2.21664 1.81306C1.49183 2.045 1 2.71878 1 3.4798V6.99985C1 8.5659 1.31923 10.1823 2.3032 11.682C3.28631 13.1805 4.88836 14.4946 7.33508 15.5367C7.75909 15.7173 8.24091 15.7173 8.66493 15.5367C11.1116 14.4946 12.7137 13.1805 13.6968 11.682C14.6808 10.1823 15 8.5659 15 6.99985V3.4798C15 2.71878 14.5082 2.045 13.7834 1.81306L8.53336 0.133063ZM7.92381 1.5617C7.97336 1.54584 8.02664 1.54584 8.07619 1.5617L13.3262 3.2417C13.4297 3.27483 13.5 3.37109 13.5 3.4798V6.99985C13.5 8.35818 13.2253 9.66618 12.4426 10.8592C11.6591 12.0535 10.3216 13.2007 8.07713 14.1567C8.02866 14.1773 7.97134 14.1773 7.92287 14.1567C5.67838 13.2007 4.34094 12.0535 3.55737 10.8592C2.77465 9.66618 2.5 8.35818 2.5 6.99985V3.4798C2.5 3.37109 2.57026 3.27483 2.67381 3.2417L7.92381 1.5617ZM11.2803 6.28021C11.5732 5.98731 11.5732 5.51244 11.2803 5.21955C10.9874 4.92665 10.5126 4.92665 10.2197 5.21955L7.25 8.18922L6.28033 7.21955C5.98744 6.92665 5.51256 6.92665 5.21967 7.21955C4.92678 7.51244 4.92678 7.98731 5.21967 8.28021L6.71967 9.78021C7.01256 10.0731 7.48744 10.0731 7.78033 9.78021L11.2803 6.28021Z"></path>
            </svg>
            <?= $_SESSION["flash"] ?>
        </div>
    <?php
        unset($_SESSION["flash"]);
    endif;
    ?>
    <!-- /通知 -->
    <!-- テーブル一覧 -->
    <div class="overflow-x-scroll no-wrap __scroll">
        <a class="color-text-secondary no-underline" href="index.php?route=home">
            <span class="label py-2 px-3 mx-1 text-bold">+</span>
        </a>
        <?php foreach ($tables as $tmp) : ?>
            <a class="color-text-secondary no-underline" href="index.php?route=home&table=<?= $tmp ?>">
                <span class="label p-2 mx-1 text-bold __hover-pointer"><?= $tmp ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <!-- /テーブル一覧 -->
    <h1 class="h1 my-4"><?= $hash["title"] ?></h1>
    <!-- Name -->
    <div class="form-group">
        <div class="form-group-header">
            <label>Name</label>
        </div>
        <div class="form-group-body">
            <input class="form-control" type="text" name="table-name" placeholder="name" value="<?= $hash["name"] ?>" />
        </div>
    </div>
    <!-- /Name -->
    <!-- Columns -->
    <div id="Columns" class="form-group">
        <div class="form-group-header">
            <label for="table-name">Columns</label>
        </div>
        <div class="form-group-body">
            <div class="overflow-x-scroll no-wrap __scroll">
                <table class="width-full text-center">
                    <thead class="<?php echo (empty($columns)) ? 'hide' : ''; ?>">
                        <tr>
                            <th scope="col" class="color-border-secondary border">Name</th>
                            <th scope="col" class="color-border-secondary border">Type</th>
                            <th scope="col" class="color-border-secondary border">Primey Key</th>
                            <th scope="col" class="color-border-secondary border">Unique</th>
                            <th scope="col" class="color-border-secondary border">Not Null</th>
                            <th scope="col" class="color-border-secondary border">Default</th>
                            <th scope="col" class="color-border-secondary border">Check</th>
                            <th scope="col" colspan="2" class="color-border-secondary border">Foreign Key</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($columns as $index => $tmp) : ?>
                            <?php
                            $constraints = $tmp->getConstraints();
                            $foreign_key = false;
                            if ($constraints["foreign_key"]) {
                                $foreign_key = $constraints["foreign_key"]["table"] . ":" . $constraints["foreign_key"]["column"];
                            }
                            ?>
                            <tr class="__hover-pointer __hover-bg" data-index="<?= $index ?>">
                                <td class="color-border-secondary border"><?= $tmp->getName() ?></td>
                                <td class="color-border-secondary border"><?= $tmp->getType() ?></td>
                                <td class="color-border-secondary border"><?php if ($constraints["primary_key"]) echo ($constraints["autoincrement"]) ? 'autoincrement' : '○'; ?></td>
                                <td class="color-border-secondary border"><?php if ($constraints["unique"]) echo '○'; ?></td>
                                <td class="color-border-secondary border"><?php if ($constraints["not_null"]) echo '○'; ?></td>
                                <td class="color-border-secondary border"><?= $constraints["default"] ?></td>
                                <td class="color-border-secondary border"><?= $constraints["check"] ?></td>
                                <?php if ($constraints["foreign_key"]) : ?>
                                    <td class="color-border-secondary border"><?= $constraints["foreign_key"]["table"] ?></td>
                                    <td class="color-border-secondary border"><?= $constraints["foreign_key"]["column"] ?></td>
                                <?php else : ?>
                                    <td class="color-border-secondary border"></td>
                                    <td class="color-border-secondary border"></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <small class="__hover-pointer mt-4 j__add d-inline-block">
            <svg class="octicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                <circle cx="12" cy="12" r="10" opacity=".35" />
                <path d="M17,13H7c-0.552,0-1-0.448-1-1v0c0-0.552,0.448-1,1-1h10c0.552,0,1,0.448,1,1v0C18,12.552,17.552,13,17,13z" />
                <path d="M11,17V7c0-0.552,0.448-1,1-1h0c0.552,0,1,0.448,1,1v10c0,0.552-0.448,1-1,1h0C11.448,18,11,17.552,11,17z" />
            </svg>
            Add Column
        </small>
        <!-- __modal -->
        <div class="__modal">
            <div class="__modal-bg j__modal-close"></div>
            <div class="__modal-content">
                <div class="Box">
                    <div class="Box-header">
                        <button class="close-button float-right j__modal-close" type="button">
                            <svg class="octicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                                <path fill-rule="evenodd" d="M3.72 3.72a.75.75 0 011.06 0L8 6.94l3.22-3.22a.75.75 0 111.06 1.06L9.06 8l3.22 3.22a.75.75 0 11-1.06 1.06L8 9.06l-3.22 3.22a.75.75 0 01-1.06-1.06L6.94 8 3.72 4.78a.75.75 0 010-1.06z"></path>
                            </svg>
                        </button>
                        <h3 class="Box-title">New Column</h3>
                    </div>
                    <ul>
                        <li class="Box-row">
                            <div class="form-group">
                                <div class="form-group-header">
                                    <label>Column</label>
                                </div>
                                <div class="form-group-body">
                                    <input class="form-control input-sm mr-2 mb-1" type="text" name="column-name" placeholder="name" />
                                    <select class="form-select select-sm mr-2 mb-1" name="column-type">
                                        <option value="none" selected disabled>Data Type</option>
                                        <option value="text">TEXT</option>
                                        <option value="integer">INTEGER</option>
                                        <option value="float">FLOAT</option>
                                        <option value="real">REAL</option>
                                        <option value="blob">BLOB</option>
                                        <option value="numeric">NUMERIC</option>
                                        <option value="date">DATE</option>
                                        <option value="time">TIME</option>
                                        <option valu="datetime">DATETIME</option>
                                        <option value="boolean">BOOLEAN</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li class="Box-row">
                            <div class="form-group">
                                <div class="form-group-header">
                                    <label>Constraint</label>
                                </div>
                                <div class="form-group-body">
                                    <div class="d-flex flex-wrap">
                                        <div class="form-checkbox flex-1">
                                            <label class="no-wrap"><input type="checkbox" name="column-primary_key" />PRIMARY KEY</label>
                                        </div>
                                        <div class="form-checkbox flex-1">
                                            <label class="no-wrap"><input type="checkbox" name="column-unique" />UNIQUE</label>
                                        </div>
                                        <div class="form-checkbox flex-1">
                                            <label class="no-wrap"><input type="checkbox" name="column-not_null" />NOT NULL</label>
                                        </div>
                                        <div class="form-checkbox flex-1">
                                            <label class="no-wrap"><input type="checkbox" name="column-autoincrement" disabled />AUTOINCREMENT</label>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <div class="form-checkbox flex-1">
                                            <label class="no-wrap">
                                                <input type="checkbox" class="form-checkbox-details-trigger" name="column-default" />
                                                DEFAULT
                                                <span class="form-checkbox-details text-normal">
                                                    <input type="text" name="default-value" class="form-control input-sm width-auto" autocomplete="on" list="function" />
                                                </span>
                                            </label>
                                        </div>
                                        <datalist id="function">
                                            <option value="date('now', 'localtime')">
                                            <option value="time('now', 'localtime')">
                                            <option value="datetime('now', 'localtime')">
                                            <option value="true">
                                            <option value="false">
                                        </datalist>
                                        <div class="form-checkbox flex-1">
                                            <label class="no-wrap">
                                                <input type="checkbox" class="form-checkbox-details-trigger" name="column-check" />
                                                CHECK
                                                <span class="form-checkbox-details text-normal">
                                                    <input type="text" name="check-value" class="form-control input-sm width-auto" />
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-checkbox flex-1">
                                            <label class="no-wrap">
                                                <input type="checkbox" class="form-checkbox-details-trigger" name="column-foreign_key" />
                                                FOREIGN KEY
                                                <div class="d-flex">
                                                    <span class="form-checkbox-details text-normal">
                                                        <select class="form-select select-sm" name="foreign_key-table">
                                                            <option value="table" selected disabled>Table</option>
                                                            <?php foreach ($tables as $tmp) : ?>
                                                                <option value="<?= $tmp ?>"><?= $tmp ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </span>
                                                    <span class="form-checkbox-details text-normal">
                                                        <select class="form-select select-sm" name="foreign_key-column">
                                                            <option selected disabled>Column</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="Box-footer">
                        <button class="btn btn-sm btn-block j__create" type="button" disabled>Create Column</button>
                        <button class="btn btn-sm btn-danger btn-block j__delete mt-2 hide" type="button">Delete Column</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /__modal -->
    </div>
    <!-- Constraints -->
    <div id="Constraints" class="form-group">
        <div class="form-group-header">
            <label>Constraints</label>
        </div>
        <div class="form-group-body">
            <ol id="Constraints" class="ml-4 d-inline-block width-fit">
                <li class="__hover-pointer py-1">sa</li>
            </ol>
        </div>
        <small class="__hover-pointer mt-4 j__add d-inline-block">
            <svg class="octicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15">
                <circle cx="12" cy="12" r="10" opacity=".35" />
                <path d="M17,13H7c-0.552,0-1-0.448-1-1v0c0-0.552,0.448-1,1-1h10c0.552,0,1,0.448,1,1v0C18,12.552,17.552,13,17,13z" />
                <path d="M11,17V7c0-0.552,0.448-1,1-1h0c0.552,0,1,0.448,1,1v10c0,0.552-0.448,1-1,1h0C11.448,18,11,17.552,11,17z" />
            </svg>
            Add Constraint
        </small>
        <!-- modal -->
        <div class="__modal">
            <div class="__modal-bg j__modal-close"></div>
            <div class="__modal-content">
                <div class="Box">
                    <div class="Box-header">
                        <button class="close-button float-right j__modal-close" type="button">
                            <svg class="octicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                                <path fill-rule="evenodd" d="M3.72 3.72a.75.75 0 011.06 0L8 6.94l3.22-3.22a.75.75 0 111.06 1.06L9.06 8l3.22 3.22a.75.75 0 11-1.06 1.06L8 9.06l-3.22 3.22a.75.75 0 01-1.06-1.06L6.94 8 3.72 4.78a.75.75 0 010-1.06z"></path>
                            </svg>
                        </button>
                        <h3 class="Box-title">New Constraint</h3>
                    </div>
                    <ul>
                        <li class="Box-row">
                            <div class="form-group">
                                <div class="form-group-header">
                                    <label>Constraint</label>
                                </div>
                                <div class="form-group-body">
                                    <select class="form-select select-sm mr-2 mb-1" name="constraint-name">
                                        <option value="none" selected disabled>Constraint</option>
                                        <option value="primary_key">PRIMARY KEY</option>
                                        <option value="unique">UNIQUE</option>
                                        <option value="check">CHECK</option>
                                        <option value="foreign_key">FOREIGN KEY</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li class="Box-row">
                            <div class="form-group">
                                <div class="form-group-header">
                                    <label>Constraint</label>
                                </div>
                                <div class="form-group-body">
                                    <div class="d-flex">
                                        <div class="form-checkbox flex-1">
                                            <label><input type="checkbox" name="column-primary_key" value="primary_key" />PRIMARY KEY</label>
                                        </div>
                                        <div class="form-checkbox flex-1">
                                            <label><input type="checkbox" name="column-unique" value="unique" />UNIQUE</label>
                                        </div>
                                        <div class="form-checkbox flex-1">
                                            <label><input type="checkbox" name="column-not_null" value="not_null" />NOT NULL</label>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <div class="form-checkbox flex-1">
                                            <label aria-live="polite">
                                                <input type="checkbox" class="form-checkbox-details-trigger" name="column-default" />
                                                DEFAULT
                                                <span class="form-checkbox-details text-normal">
                                                    <input type="text" name="default-value" class="form-control input-sm width-auto" autocomplete="on" list="function" />
                                                </span>
                                            </label>
                                        </div>
                                        <datalist id="function">
                                            <option value="date('now', 'localtime')">
                                            <option value="time('now', 'localtime')">
                                            <option value="datetime('now', 'localtime')">
                                            <option value="true">
                                            <option value="false">
                                        </datalist>
                                        <div class="form-checkbox flex-1">
                                            <label aria-live="polite">
                                                <input type="checkbox" class="form-checkbox-details-trigger" name="column-check" />
                                                CHECK
                                                <span class="form-checkbox-details text-normal">
                                                    <input type="text" name="check-value" class="form-control input-sm width-auto" />
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-checkbox flex-1">
                                            <label aria-live="polite">
                                                <input type="checkbox" class="form-checkbox-details-trigger" name="column-foreign_key" />
                                                FOREIGN KEY
                                                <div class="d-flex">
                                                    <span class="form-checkbox-details text-normal">
                                                        <select class="form-select select-sm" name="foreign_key-table">
                                                            <option value="table" selected disabled>Table</option>
                                                            <?php foreach ($tables as $tmp) : ?>
                                                                <option value="<?= $tmp ?>"><?= $tmp ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </span>
                                                    <span class="form-checkbox-details text-normal">
                                                        <select class="form-select select-sm" name="foreign_key-column">
                                                            <option selected disabled>Column</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="Box-footer">
                        <button class="btn btn-sm btn-block j__create mb-2" type="button">Create Column</button>
                        <button class="btn btn-sm btn-danger btn-block j__delete" type="button">Delete Column</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /modal -->
    </div>
    <!-- /Constraints -->
    <div class="form-group">
        <div class="form-group-header">
            <label for="table-name">Schema</label>
        </div>
        <div class="form-group-body">
            <code>
                <textarea class="form-control" name="table-schema" readonly placeholder="schema"><?= $hash["schema"] ?></textarea>
            </code>
        </div>
    </div>
    <form id="Create" action="controller/_drop.php" method="post">
        <input type="hidden" name="delete-table-name" value="<?= $hash["name"] ?>">
        <button class="btn btn-block" type="submit"><?php echo ($hash["flag"]) ? 'Update Table' : 'Create Table'; ?></button>
    </form>
    <?php if ($hash["flag"]) : ?>
        <form id="Delete" action="controller/_drop.php" method="post">
            <input type="hidden" name="delete-table-name" value="<?= $hash["name"] ?>">
            <button class="btn btn-danger btn-block mt-2" type="submit">Drop Table</button>
        </form>
    <?php endif; ?>
</main>
<footer>

</footer>
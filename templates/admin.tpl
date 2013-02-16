{extends file="./layout.tpl"}
{block name="form"}
    <style>

        .sestylejs_admin .widget {
            float: left;
            display: inline-block;
            clear: both;
            margin: 10px;
            width: 100%;
        }


        .sestylejs_admin .widget.right {
            float: right;
        }

        .sestylejs_admin textarea {
            width: 90%;
            height: 300px;
        }

    </style>
    <form method="POST">
        <div class="widget right">
            <input type="submit" name="sestylejs" value="Enregistrer">
        </div>
    {foreach item=widget from=$form}
        <div class="widget">
            {assign var=trans_key value=$widget.id}
            <label for="{$widget.id}">{$trans.$trans_key}</label>
            <textarea id="{$widget.id}" name="{$widget.id}" value="{$widget.value}">{$widget.value}</textarea>
        </div>
    {/foreach}
    </form>
    <script type="text/javascript" src="{$root_url}/modules/sestylejs/public/editarea_0_8_2/edit_area/edit_area_compressor.php"></script>
    <script type="text/javascript">
        {foreach item=widget from=$form}
        editAreaLoader.init({
            id: "{$widget.id}",
            start_highlight: true,
            allow_resize: "both",
            allow_toggle: true,
            word_wrap: true,
            language: "en",
            syntax: "{$widget.language}"
        });
        {/foreach}
    </script>
{/block}
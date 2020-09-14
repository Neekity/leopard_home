<?php
/**
 * @var App\Components\Table $table
 * @var string               $tableId
 */
?>

<script>
    @foreach($table->jsOptions as $key => $jsOptions)
    jQuery('#{{ $tableId }}').tableView('{{ $key }}',  {!! $jsOptions !!});
    @endforeach

    @foreach($table->headerButtons as $headerButton)
        @if(!empty($headerButton->renderJs()))
            {!! $headerButton->renderJs() !!}
        @endif
    @endforeach
</script>

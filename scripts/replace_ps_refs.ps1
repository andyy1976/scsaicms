$files = Get-ChildItem 'D:\scsaicms\Web\Tpl\sciotai\' -Recurse -Filter '*.html'
$count = 0
foreach ($f in $files) {
    $content = [System.IO.File]::ReadAllText($f.FullName, [System.Text.Encoding]::UTF8)
    if ($content -match '_ps') {
        $newContent = $content -replace 'head_ps', 'head' -replace 'footer_ps', 'footer'
        [System.IO.File]::WriteAllText($f.FullName, $newContent, (New-Object System.Text.UTF8Encoding $false))
        $count++
        Write-Host "Fixed: $($f.Name)"
    }
}
Write-Host "`nTotal files fixed: $count"

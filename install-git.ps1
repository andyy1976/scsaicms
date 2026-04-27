$ErrorActionPreference = "Stop"

# Download Git installer
$gitInstallerUrl = "https://github.com/git-for-windows/git/releases/download/v2.45.2.windows.1/Git-2.45.2-64-bit.exe"
$gitInstallerPath = "$env:TEMP\Git-2.45.2-64-bit.exe"

Write-Host "Downloading Git installer..."
Invoke-WebRequest -Uri $gitInstallerUrl -OutFile $gitInstallerPath -UseBasicParsing

# Install Git
Write-Host "Installing Git..."
Start-Process -FilePath $gitInstallerPath -ArgumentList "/SILENT /NORESTART /COMPONENTS=icons,icons\quicklaunch,gitlfs,shell\ext,shell\integration,contextmenu,assoc,assoc_sh" -Wait

# Add Git to PATH
$gitPath = "C:\Program Files\Git\bin"
[Environment]::SetEnvironmentVariable("Path", "$env:Path;$gitPath", "Machine")

# Verify installation
Write-Host "Verifying Git installation..."
git --version

Write-Host "Git installation completed!"
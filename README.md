# Electron Updater Server PHP

## Usage

Send
`https://my-electron-updater-server.com/?version=1.0.0&env=win32&arch=x64`

### Return
#### no new version
`HTTP/1.0 204 No Content`

#### new version
##### Windows
```
{
  'url': 'https://my-electron-updater-server.com/releases/win32/x64/1.0.1/',
  'name': 'Project name',
  'notes': 'Update',
  'pub_date': '2018-08-26T19:57:53+01:00',
}
```

##### Mac
```
{
  'url': 'https://my-electron-updater-server.com/releases/win32/x64/1.0.1/myproject-darwin-x64.zip',
  'name': 'myproject',
  'notes': 'Update',
  'pub_date': '2018-08-26T19:57:53+01:00',
}
```

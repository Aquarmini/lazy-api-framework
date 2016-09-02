# -*- coding: UTF-8 -*-
import os
import sys
import zipfile
import hashlib
import shutil
import compileall
import time

SERVER_DIR = r"E:\phpStudy\WWW\_Lmx\_Empty\branches\api"
APP = r"api.tp5"
APP_VERTION = r"2.0"
APP_TIME = time.strftime('%Y%m%d%H%M%S')
APP_NAME = r"api"

def build_gma_version(version, version_dir, include_static_files=False):

    # copy application files
    print("=========================  COPY  application FILES  ===========================")
    os.mkdir('application')
    os.chdir('application')
    os.system(r'xcopy %s\application\common.php' % SERVER_DIR)
    os.system(r'xcopy %s\application\command.php' % SERVER_DIR)
    os.system(r'xcopy %s\application\config.php' % SERVER_DIR)
    os.system(r'xcopy %s\application\route.php' % SERVER_DIR)
    print("=========================  COPY  application.common FILES  ===========================")
    os.mkdir('common')
    os.chdir('common')
    os.system(r'xcopy /s %s\application\common\*.php' % SERVER_DIR)
    os.chdir('..')
    print("=========================  COPY  application.data FILES  ===========================")
    os.mkdir('data')
    os.chdir('data')
    os.system(r'xcopy /s %s\application\data\*.php' % SERVER_DIR)
    os.chdir('..')
    print("=========================  COPY  application.api FILES  ===========================")
    os.mkdir('api')
    os.chdir('api')
    os.system(r'xcopy /s %s\application\api\*.*' % SERVER_DIR)
    os.chdir('..')
    print("=========================  COPY  application.index FILES  ===========================")
    os.mkdir('index')
    os.chdir('index')
    os.system(r'xcopy /s %s\application\index\*.*' % SERVER_DIR)
    os.chdir('..')
    os.chdir('..')
    print("=========================  COPY  extend FILES  ===========================")
    os.mkdir('extend')
    os.chdir('extend')
    os.system(r'xcopy /s %s\extend\*.php' % SERVER_DIR)
    os.chdir('..')
    print("=========================  COPY  public FILES  ===========================")
    os.mkdir('public')
    os.chdir('public')
    os.mkdir('static')
    os.chdir('static')
    os.mkdir('basic')
    os.chdir('basic')
    os.system(r'xcopy /s %s\public\static\basic\*.*' % SERVER_DIR)
    os.chdir('..')
    os.mkdir('image')
    os.chdir('image')
    os.system(r'xcopy /s %s\public\static\image\*.*' % SERVER_DIR)
    os.chdir('..')
    os.mkdir('js')
    os.chdir('js')
    os.system(r'xcopy /s %s\public\static\js\*.js' % SERVER_DIR)
    os.chdir('..')
    os.mkdir('css')
    os.chdir('css')
    os.system(r'xcopy /s %s\public\static\css\*.css' % SERVER_DIR)
    os.chdir('..')
    os.chdir('..')
    os.chdir('..')

def pack_version(version_dir, zip_file_name):
    os.chdir('..')
    zip_file = zipfile.ZipFile(zip_file_name, 'w', zipfile.ZIP_DEFLATED)
    for root, dirs, files in os.walk(version_dir):
        for file in files:
            file_path = '%s/%s' % (root, file)
            zip_file.write(file_path)
    zip_file.close()

    # remove temporary file
    shutil.rmtree(version_dir)




if __name__ == '__main__':
    version = APP_VERTION
    version_dir = APP_NAME
    version_dir_zip = APP + '_v%s' % version + '_t%s' % APP_TIME
    version_dir_path = os.path.abspath('./versions/%s' % version_dir)
    zip_file_name = '%s.zip' % version_dir_zip

    if os.path.exists(version_dir_path):
        print("ERROR: %s is exists!" % version_dir_path)
        exit(0)

    # create root dir
    # os.chdir('/')
    os.chdir('/phpStudy/WWW/zips')
    os.mkdir(version_dir)
    os.chdir(version_dir)

    # build version
    build_gma_version(version, version_dir_path, include_static_files=True)

    # zip file
    pack_version(version_dir, zip_file_name)
    print('OK')
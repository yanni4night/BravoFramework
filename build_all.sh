modules=`ls Demo`
here=`pwd`
rm -rf Release
mkdir Release
for m in $modules
do
    if [ -d "Demo/$m" ];then
        cd "Demo/$m"
        make
        cp -r output/* ../../Release/
        cd $here
    fi
done

cp Demo/index.php Release/
openssl req -x509 -newkey rsa:4096 -sha256 -days 3650 -nodes \
  -keyout apache.key -out apache.crt -subj "/CN=test5.fivesys.dev"

#echo "STEP 1 --------------------"
#openssl genrsa -out apache.key 4096
#
#echo "STEP 2 --------------------"
#openssl req -new -key apache.key \
#  -out apache.csr \
#  -config apache.cnf
#
#echo "STEP 3 --------------------"
#openssl x509 -sha256 -req -days 365 \
#  -in apache.csr \
#  -signkey apache.key \
#  -out apache.crt
#
#
#sudo rm /usr/local/share/ca-certificates/apache.crt
#sudo update-ca-certificates -v
#
#sudo cp ./apache.crt /usr/local/share/ca-certificates/
#
#sudo update-ca-certificates -v
#openssl verify apache.crt

#$ sudo mkdir /usr/share/ca-certificates/extra
#$ sudo cp my.crt /usr/share/ca-certificates/extra/mycert1.crt
#$ sudo vim /etc/ca-certificates.conf

#sudo apt install libnss3-tools

#certfile="apache.crt"
#certname="lan.ipsycholog.net"
#for certDB in $(find ~/ -name "cert8.db")
#do
#certdir=$(dirname ${certDB});
#certutil -A -n "${certname}" -t "TCu,Cu,Tu" -i ${certfile} -d dbm:${certdir}
#done
#for certDB in $(find ~/ -name "cert9.db")
#do
#certdir=$(dirname ${certDB});
#certutil -A -n "${certname}" -t "TCu,Cu,Tu" -i ${certfile} -d sql:${certdir}
#done

#!/bin/bash
#目录
log2kafka="/DATA/waltz"
log_backup="/mfw_data/waltz"
kafka_brokers="192.168.4.72:9092,192.168.4.73:9092,192.168.4.74:9092"
log_source="sales"
topic="log.mysql_binlog"

#时间
c_min=`date +%Y%m%d%H%M`
l_min=`date -d "-1 minutes" +%Y%m%d%H%M`
l_day=`echo ${l_min:0:8}`

#tail file
function fileTail() {
     source=$1
     base_file="$log2kafka/$source/binlog"
     tail_file="$base_file.$c_min"
     c_sec=`date +%S`
     while [ ! -f "$tail_file" ]
     do
         if [[ ${c_sec} -gt 60 ]];then
                 return
         fi
         let c_sec=c_sec+1
         sleep 1
     done
     check_pid=`ps aux|grep tail|grep ${base_file}|grep  ${c_min}|awk '{print $2}'`
     if ! test ${check_pid}
     then
         tail -n +1 -f ${tail_file}|/usr/bin/kafkacat -P -b ${kafka_brokers} -t ${topic} -K '^' -p -1 -z gzip
     fi
}

#backup file
function backupFile(){

   for source in ${log_source}
    do
        c_file="$log2kafka/$source/binlog.$c_min"
        l_bakdir="$log_backup/$source/$l_day/"

        if [ ! -d "$l_bakdir" ]
        then
            mkdir -p ${l_bakdir}
            chmod 0755 ${l_bakdir}
        fi
        for l_file in ${log2kafka}/${source}/*
        do
            if [ ${l_file} !=  ${c_file} ]
            then
                 mv ${l_file} ${l_bakdir}
            fi
        done
    done
}

#tail log to kafka
function tail2Kafka() {
    for source in  ${log_source}
    do
       fileTail ${source} &
    done
}

#stop tail2kafka
function stopTail2Kafka(){
    for source in ${log_source}
    do
        base_file="$log2kafka/$source/binlog"
        check_pid=`ps aux|grep tail|grep ${base_file}|grep -v ${c_min}|awk '{print $2}'`
        if test "$check_pid"
        then
           kill -9 ${check_pid}
        fi
    done
}

tail2Kafka
sleep 5
stopTail2Kafka
backupFile
exit
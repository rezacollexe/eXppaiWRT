#!/bin/bash

ip=$1
if [[ $ip =~ ^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
  echo -e "invalid domain"
  exit 1
fi

if [[ -n "$1" ]];
then
echo -e "Processing Domain : <code>$1</code>"
echo -e "==================="
else
	echo -e "Domain cant be empty"
    exit 1
fi

iplist=$(host $1 | awk '/has address/ { print $4 }')

tout=5
if [[ -n "$2" ]];
then
	if [ $2 == "wait" ]
	then
    	tout=300
	fi
fi


mebur=$(wget -O- /dev/null $1 2>&1 -t 1 --timeout=$tout)
    isBongko=0
    StatusString=$mebur
    connectedPort="0"
    if [[ "$StatusString" == *"|:80... connected."* ]]
    then
    	connectedPort="80"
        code="200"
    fi
    if [[ "$StatusString" == *"|:443... connected."* ]]
    then 
    	if [[ "$connectedPort" == "80" ]]
        then
        	connectedPort="80 and 443"
        else
	    	connectedPort="443"
        fi
        code="200"
    fi
    #echo "result $StatusString"
    if [[ $connectedPort == "0" ]];
    then
    	echo -e "$1 Not Available to process"
    else
	check=$(wget -qSO /dev/null $1 2>&1 -t 1 --timeout=5 | grep -i 'CF-Cache-Status:' |  cut -d: -f2- | sed 's/ //g')
        iplist=$(host $1 | awk '/has address/ { print $4 }')
        joni=$(curl -Is /dev/null $1 | grep -i ^Server: | cut -d: -f2- | sed 's/ //g')
        
		if [ "$check" == "HIT"* ] || [ "$check" == "DYNAMIC"* ] || [ "$check" == "EXPIRED"* ] || [ "$check" == "MISS"* ] || [ "$check" == "BYPASS"* ] || [[ "$joni" == "cloudflare"* ]]
	    then	
	        IsCloudflare="YES"
	        echo -e "Port Open  : $connectedPort"
	        #echo -e "$iplist"
			while IFS= read -r line
			do
    			echo -e "<code>$line</code>"
			done <<< "$iplist"
	        if [ "$code" == "200" ]
	        then
	            echo -e "Status     : [$code]"
	        else
	            echo -e "Status     : [$code]"
	        fi
	        echo -e "Cloudflare     : [YES]"

	    else
            echo -e "Port Open  : $connectedPort"
	        #echo -e "$iplist"
            while IFS= read -r line
			do
    			echo -e "<code>$line</code>"
			done <<< "$iplist"

	        if [ "$code" == "200" ]
	        then
	            echo -e "Status     : [$code]"	
	        else
	            echo -e "Status     : [$code]"
	        fi
			if [[ "$StatusString" == *"ERROR 522: (no description)." ]]
        	then
            	echo -e "Cloudflare     : [YES]"
            	echo -e "Cloudflare connection time out, possibility BONGKO already"
            else
            	echo -e "Cloudflare     : [NO]"
        	fi
            
            
	    fi
        
    fi

// @flow
import * as React from 'react';
import MUIDataTable, {MUIDataTableColumn, MUIDataTableOptions} from "mui-datatables";
import {useEffect, useState} from "react";
import {httpVideo} from "../../util/http";
import {Chip} from "@material-ui/core";
import format from 'date-fns/format'
import parseISO from 'date-fns/parseISO'

const type = [
   'Diretor',
    'Ator'
]

const columnsDefinition: MUIDataTableColumn[] = [
    {
        name: "name",
        label: "Nome"
    },
    {
        name: 'type',
        label: 'Tipo',
        options:{
            customBodyRender(value, tableMeta, updateValue): any {
                return <span>{type[value]}</span>
            }
        }
    },
    {
        name: "created_at",
        label: "Criado em",
        options:{
            customBodyRender(value, tableMeta, updateValue) {
                return <span>{format(parseISO(value), 'dd/MM/yyyy H:m')}</span>
            }
        }
    }
]

const options:MUIDataTableOptions = {
    textLabels: {
        pagination: {
            rowsPerPage: "Itens por página"
        }
    }
}

type Props = {
    
};

const Table = (props: Props) => {
    const [data, setData] = useState([])

    useEffect(()=>{
        httpVideo.get('/cast_members').then(res => {
            setData(res.data)
        })
    },[])

    return (
        <MUIDataTable columns={columnsDefinition}
                      title=""
                      data={data}
                      options={options}
        >
        </MUIDataTable>
    );
};

export default Table
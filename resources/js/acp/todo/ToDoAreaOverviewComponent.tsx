import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../component/atoms/PageHeadline';
import ButtonAddLine from '../../component/molecules/ButtonAddLine';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SortTable from '../../component/molecules/SortTable';
import { ToDoAreaProps } from '../../props/props';
import { checkContentTitle, editLink } from '../helper';

function returnToDoList(props: any, headline) {
  if (typeof props.areas === 'undefined') {
    return <></>;
  }
  const areas = [...props.areas];
  const ths = ['Bereich', 'Editieren'];
  const datas = [] as any;
  const table_id = 'adminOverviewToDos';
  areas.map((item, index) => {
    datas.push([
      { content: checkContentTitle(item.label), className: '' },
      { content: editLink(props, item), className: '' },
    ] as any);
    return '';
  });

  return (
    <div>
      <SortTable
        headline={headline}
        table_id={table_id}
        datas={datas}
        ths={ths}
        showPaginationList={false}
        showSearchBox={false}
      />
    </div>
  );
}

const ToDoAreaOverviewComponent: React.FC<ToDoAreaProps> = (props: ToDoAreaProps): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);

  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch('/api/admin/todo/area/overview');
      response = await response.json();
      setAppState(response);
      setLoading(false);
    }

    fetchMyApi();
  }, []);

  if (loading || appState === null) {
    return <LoadingAlertBox />;
  }
  return (
    <div className="container">
      <div className="overview_headline">
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <PageHeadline label="Admin - ToDo Area List" />
          </Col>
        </Row>
      </div>
      <ButtonAddLine url="/admin/todo/area/add" />
      {returnToDoList(appState, 'Admin - ToDo Area List')}
      <ButtonAddLine url="/admin/todo/area/add" />
    </div>
  );
};
export default ToDoAreaOverviewComponent;

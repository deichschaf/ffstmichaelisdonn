import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../component/atoms/PageHeadline';
import ButtonAddLine from '../../component/molecules/ButtonAddLine';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SortTable from '../../component/molecules/SortTable';
import { ToDoAreaProps } from '../../props/props';
import { checkContentTitle, deleteLink, editLink, isActive } from '../helper';

function returnToDoList(props: any, headline) {
  if (typeof props.news === 'undefined') {
    return <></>;
  }
  const areas = [...props.news];
  const ths = ['Datum', 'Titel', 'Aktiv', 'Löschen', 'Editieren'];
  const datas = [] as any;
  const table_id = 'adminOverviewToDos';
  areas.map((item, index) => {
    datas.push([
      { content: checkContentTitle(item.created_at), className: '' },
      { content: checkContentTitle(item.title), className: '' },
      { content: isActive(item.active), className: '' },
      { content: deleteLink(props, item), className: '' },
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

const NewsOverviewComponent: React.FC<ToDoAreaProps> = (props: ToDoAreaProps): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);

  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch('/api/admin/news/overview');
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
            <PageHeadline label="Admin - News List" />
          </Col>
        </Row>
      </div>
      <ButtonAddLine url="/admin/news/add" />
      {returnToDoList(appState, 'Admin - News List')}
      <ButtonAddLine url="/admin/news/add" />
    </div>
  );
};
export default NewsOverviewComponent;

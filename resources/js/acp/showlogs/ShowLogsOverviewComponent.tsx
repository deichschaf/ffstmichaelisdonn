import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../component/atoms/PageHeadline';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SortTable from '../../component/molecules/SortTable';
import { ShowLogsProps } from '../../props/props';
import { checkContentTitle, editLink } from '../helper';

function returnShowLogList(props: any, headline) {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.logs === 'undefined') {
    return <></>;
  }

  const areas = [...props.data.logs];
  const ths = ['Datum/Zeit', 'ENV', 'Typ', 'Message'];
  const datas = [] as any;
  const table_id = 'adminOverviewSystemLogs';
  areas.map((item, index) => {
    datas.push([
      { content: checkContentTitle(item.timestamp), className: '' },
      { content: checkContentTitle(item.env), className: '' },
      { content: checkContentTitle(item.type), className: '' },
      { content: checkContentTitle(item.message), className: '' },
    ] as any);
    return '';
  });

  return (
    <div>
      <SortTable
        headline={`${headline} ${props.data.date}`}
        table_id={table_id}
        datas={datas}
        ths={ths}
        showPaginationList={false}
        showSearchBox={false}
      />
    </div>
  );
}

const ShowLogsOverviewComponent: React.FC<ShowLogsProps> = (props: ShowLogsProps): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);

  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch('/api/admin/system/log-reader');
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
            <PageHeadline label="Admin - System Log" />
          </Col>
        </Row>
      </div>
      {returnShowLogList(appState, 'Admin - System Log')}
    </div>
  );
};
export default ShowLogsOverviewComponent;

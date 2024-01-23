import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../../component/atoms/PageHeadline';
import ButtonAddLine from '../../../component/molecules/ButtonAddLine';
import LoadingAlertBox from '../../../component/molecules/LoadingAlertBox';
import SortTable from '../../../component/molecules/SortTable';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { EmergencyOverviewComponentProps } from '../../../props/props';
import { checkContentTitle, editLink, isActive, isActiveCheck } from '../../helper';

function returnEmergencyList(props: any, headline) {
  if (typeof props.emergencies === 'undefined') {
    return <div />;
  }
  const emergencies = [...props.emergencies];
  const ths = ['Datum', 'Einsatzart', 'Einsatzort', 'Alarm', 'Löschhilfe', 'Aktiv', 'Editieren'];
  const datas = [] as any;
  emergencies.map((item, idx) =>
    datas.push([
      { content: checkContentTitle(item.beginn), className: '' },
      { content: checkContentTitle(item.einsatz_art), className: '' },
      { content: checkContentTitle(item.einsatz_ort), className: '' },
      { content: isActiveCheck(item.is_alarm), className: '' },
      { content: isActiveCheck(item.loeschhilfe), className: '' },
      { content: isActive(item.active), className: '' },
      { content: editLink(props, item), className: '' },
    ] as any)
  );

  return (
    <SortTable
      headline={headline}
      table_id="adminOverviewContent"
      datas={datas}
      ths={ths}
      showPaginationList={false}
      showSearchBox={false}
    />
  );
}

const EmergencyActionOverviewComponent: React.FC<
  React.PropsWithChildren<EmergencyOverviewComponentProps>
> = (props: EmergencyOverviewComponentProps): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);
  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch('/api/admin/emergency/overview');
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
            <PageHeadline label="Admin - Einsätze" />
          </Col>
        </Row>
      </div>
      <ButtonAddLine url="/admin/emergency/add" />
      <ErrorBoundary>{returnEmergencyList(appState, 'Admin - Einsätze')}</ErrorBoundary>
      <ButtonAddLine url="/admin/emergency/add" />
    </div>
  );
};
export default EmergencyActionOverviewComponent;

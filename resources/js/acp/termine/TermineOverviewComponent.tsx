import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../component/atoms/PageHeadline';
import ButtonAddLine from '../../component/molecules/ButtonAddLine';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SortTable from '../../component/molecules/SortTable';
import ErrorBoundary from '../../component/organisms/errorboundary';
import { TermineOverviewComponentProps } from '../../props/props';
import {
  checkContentTitle,
  checkIsBrocken,
  copyLink,
  deleteLink,
  editLink,
  getGermanMonthName,
} from '../helper';

const TermineOverviewComponent: React.FC<React.PropsWithChildren<TermineOverviewComponentProps>> = (
  props: TermineOverviewComponentProps,
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [appState, setAppState] = useState<any>(null);
  const [getYear, setYear] = useState<number>(0);
  const [getMonth, setMonth] = useState<number>(0);

  function buildYearRow(datas, item) {
    datas.push([
      { content: item.headline_year, className: '' },
      { content: '', className: '' },
      { content: '', className: '' },
      { content: '', className: '' },
      { content: '', className: '' },
      { content: '', className: '' },
    ] as any);
  }

  function buildMonthRow(datas, item) {
    const month = parseInt(item.headline_month, 10);
    datas.push([
      { content: getGermanMonthName(month), className: '' },
      { content: '', className: '' },
      { content: '', className: '' },
      { content: '', className: '' },
      { content: '', className: '' },
      { content: '', className: '' },
    ] as any);
  }
  function buildRows(datas, item) {
    if (item.headline_year !== undefined) {
      buildYearRow(datas, item);
    } else if (item.headline_month !== undefined) {
      buildMonthRow(datas, item);
    } else {
      datas.push([
        { content: checkContentTitle(`${item.dayofweek}, ${item.day}`), className: '' },
        { content: checkContentTitle(item.time_start), className: '' },
        { content: checkContentTitle(item.title), className: '' },
        { content: deleteLink(props, item), className: '' },
        { content: copyLink(props, item), className: '' },
        { content: editLink(props, item), className: '' },
      ] as any);
    }
  }
  function returntermineList(props: any, headline) {
    if (typeof props.termine === 'undefined') {
      return <></>;
    }
    const termine = [...props.termine];
    const ths = ['Titel', 'Url', 'Kategorie', 'erreichbar', 'Löschen', 'Editieren'];
    const datas = [] as any;
    termine.map((item, idx) => buildRows(datas, item));

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
  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch('/api/admin/termine/overview');
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
            <PageHeadline label="Admin - Termine List" />
          </Col>
        </Row>
      </div>
      <ButtonAddLine url="/admin/termine/add" />
      <ErrorBoundary>{returntermineList(appState, 'Admin - Termine List')}</ErrorBoundary>
      <ButtonAddLine url="/admin/termine/add" />
    </div>
  );
};
export default TermineOverviewComponent;

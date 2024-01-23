import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentEmergencyStatisticProps } from '../../../../../props/props';
import StatisticPie from '../../../../atoms/Statistic/StatisticPie';
import StatisticVerticalBar from '../../../../atoms/Statistic/StatisticVerticalBar';
import ErrorBoundary from '../../../errorboundary';
import EmergencyMonthStatistic from '../ContentEmergency/modules/EmergencyMonthStatistic';
import ContentSectorHeadline from '../ContentSectorHeadline';

const ContentEmergencyStatistic: React.FC<
  React.PropsWithChildren<ContentEmergencyStatisticProps>
> = (props: ContentEmergencyStatisticProps): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.emergency_statistic === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      {typeof props.data.emergency_statistic.monthstatistic !== 'undefined' ? (
        <EmergencyMonthStatistic data={props.data.emergency_statistic.monthstatistic} />
      ) : (
        <></>
      )}
      {typeof props.data.emergency_statistic.countStatistic !== 'undefined' ? (
        <>
          <ContentSectorHeadline>
            Einsätze FF Sankt Michaelisdonn {props.data.emergency_statistic.countStatistic.startYear} -{' '}
            {props.data.emergency_statistic.countStatistic.endYear}
          </ContentSectorHeadline>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <StatisticPie
                data={props.data.emergency_statistic.countStatistic.data}
                legende={props.data.emergency_statistic.countStatistic.legende}
              />
            </Col>
          </Row>
        </>
      ) : (
        <></>
      )}
      {typeof props.data.emergency_statistic.statistic !== 'undefined' ? (
        <>
          <ContentSectorHeadline>
            Einsätze FF Sankt Michaelisdonn {props.data.emergency_statistic.statistic.startYear} -{' '}
            {props.data.emergency_statistic.statistic.endYear}
          </ContentSectorHeadline>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <StatisticPie
                data={props.data.emergency_statistic.statistic.data}
                legende={props.data.emergency_statistic.statistic.legende}
              />
            </Col>
          </Row>
        </>
      ) : (
        <></>
      )}
      {typeof props.data.emergency_statistic.area !== 'undefined' ? (
        <>
          <ContentSectorHeadline>Einsatzgebiet FF Sankt Michaelisdonn</ContentSectorHeadline>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <StatisticVerticalBar
                data={props.data.emergency_statistic.area.data}
                legende={props.data.emergency_statistic.area.legende}
              />
            </Col>
          </Row>
        </>
      ) : (
        <></>
      )}
      {typeof props.data.emergency_statistic.overview !== 'undefined' ? (
        <>
          <ContentSectorHeadline>Einsatzübersicht FF Sankt Michaelisdonn</ContentSectorHeadline>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <StatisticVerticalBar
                data={props.data.emergency_statistic.overview.data}
                legende={props.data.emergency_statistic.overview.legende}
              />
            </Col>
          </Row>
        </>
      ) : (
        <></>
      )}
    </ErrorBoundary>
  );
};
export default ContentEmergencyStatistic;

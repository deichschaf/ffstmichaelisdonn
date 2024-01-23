import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { BuildEmergencyYearProps } from '../../../../../../props/props';
import H1 from '../../../../../atoms/Typography/H1';
import ErrorBoundary from '../../../../errorboundary';
import BuildEmergencyEmpty from './BuildEmergencyEmptyYear';
import BuildEmergencyMonths from './BuildEmergencyMonths';
import EmergencyMonthStatistic from './EmergencyMonthStatistic';

const BuildEmergencyYear: React.FC<React.PropsWithChildren<BuildEmergencyYearProps>> = (
  props: BuildEmergencyYearProps,
): JSX.Element => {
  if (typeof props.year === 'undefined') {
    return <></>;
  }
  const { data } = props;
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <H1 label={props.year} />
        </Col>
      </Row>
      <EmergencyMonthStatistic data={[props.statistic]} />
      {/* eslint-disable-next-line no-nested-ternary */}
      {typeof props.data === 'undefined' ? (
        <BuildEmergencyEmpty />
      ) : data.length === 0 ? (
        <BuildEmergencyEmpty />
      ) : (
        <BuildEmergencyMonths year={props.year} data={data} />
      )}
    </ErrorBoundary>
  );
};
export default BuildEmergencyYear;

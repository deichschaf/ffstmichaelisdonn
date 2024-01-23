import { Col, Row } from 'react-bootstrap';
import { StationSearchListProps } from '../../../../../../props/props';
import H3 from '../../../../../atoms/Typography/H3';
import ErrorBoundary from '../../../../errorboundary';
import StationCard from '../../ContentStationOverview/components/StationCard';

const StationSearchList: React.FC<React.PropsWithChildren<StationSearchListProps>> = (
  props: StationSearchListProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (props.data === null) {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <H3 label="Gefundende Stationen" />
        </Col>
      </Row>
      <Row>
        {props.data.map((item, idx) => (
          <StationCard key={idx} data={item} />
        ))}
      </Row>
    </ErrorBoundary>
  );
};
export default StationSearchList;

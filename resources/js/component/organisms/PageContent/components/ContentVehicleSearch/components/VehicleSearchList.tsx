import { Col, Row } from 'react-bootstrap';
import { VehicleSearchListProps } from '../../../../../../props/props';
import H3 from '../../../../../atoms/Typography/H3';
import ErrorBoundary from '../../../../errorboundary';
import VehicleCard from './VehicleCard';

const VehicleSearchList: React.FC<React.PropsWithChildren<VehicleSearchListProps>> = (
  props: VehicleSearchListProps,
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
          <H3 label="Gefundende Fahrzeuge" />
        </Col>
      </Row>
      <Row>
        {props.data.map((item, idx) => (
          <VehicleCard key={idx} data={item} />
        ))}
      </Row>
    </ErrorBoundary>
  );
};
export default VehicleSearchList;

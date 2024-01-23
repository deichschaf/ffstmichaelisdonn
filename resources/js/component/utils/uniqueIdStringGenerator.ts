// TODO: Eventually use random generator with settable seed
const uniqueIdStringGenerator = (): string => Math.random().toString(36).substr(2, 9);

export default uniqueIdStringGenerator;
